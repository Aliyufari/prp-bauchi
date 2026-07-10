<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Lga;
use App\Models\Pu;
use App\Models\State;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Ward;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->role('member') // Spatie scope — adjust role name to match yours
            ->with(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $members = $query->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return Inertia::render('dashboard/members/Index', [
            'members' => [
                'data' => MemberResource::collection($members->items()),
                'meta' => [
                    'current_page' => $members->currentPage(),
                    'last_page' => $members->lastPage(),
                    'from' => $members->firstItem(),
                    'to' => $members->lastItem(),
                    'per_page' => $members->perPage(),
                    'total' => $members->total(),
                ],
            ],
            'statistics' => $this->statistics(),
            'filterOptions' => [
                'states' => State::orderBy('name')->get(['id', 'name']),
                'zones' => Zone::orderBy('name')->get(['id', 'name']),
                'lgas' => Lga::orderBy('name')->get(['id', 'name']),
                'wards' => Ward::orderBy('name')->get(['id', 'name']),
                'statuses' => [
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'inactive', 'label' => 'Inactive'],
                ],
            ],
            'formOptions' => [
                'states' => State::orderBy('name')->get(['id', 'name']),
                'zones' => Zone::orderBy('name')->get(['id', 'name']),
                'lgas' => Lga::orderBy('name')->get(['id', 'name']),
                'wards' => Ward::orderBy('name')->get(['id', 'name']),
                'pus' => Pu::orderBy('name')->get(['id', 'name']),
            ],
            'filters' => $request->only(['search', 'state', 'zone', 'lga', 'ward', 'status']),
        ]);
    }

    public function store(StoreMemberRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            $user = User::create([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole('member');

            $user->profile()->create([
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'education_status' => $data['education_status'] ?? null,
                'application_id' => $data['application_id'] ?? null,
                'state_id' => $data['state_id'] ?? null,
                'zone_id' => $data['zone_id'] ?? null,
                'lga_id' => $data['lga_id'] ?? null,
                'ward_id' => $data['ward_id'] ?? null,
                'pu_id' => $data['pu_id'] ?? null,
                'mentor_name' => $data['mentor_name'] ?? null,
                'mentor_status' => $data['mentor_status'] ?? false,
                'training_status' => $data['training_status'] ?? false,
            ]);
        });

        return back()->with('success', 'Member created.');
    }

    public function update(UpdateMemberRequest $request, User $member)
    {
        DB::transaction(function () use ($request, $member) {
            $data = $request->validated();

            $member->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);

            $member->profile()->updateOrCreate(['user_id' => $member->id], [
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'education_status' => $data['education_status'] ?? null,
                'application_id' => $data['application_id'] ?? null,
                'state_id' => $data['state_id'] ?? null,
                'zone_id' => $data['zone_id'] ?? null,
                'lga_id' => $data['lga_id'] ?? null,
                'ward_id' => $data['ward_id'] ?? null,
                'pu_id' => $data['pu_id'] ?? null,
                'mentor_name' => $data['mentor_name'] ?? null,
                'mentor_status' => $data['mentor_status'] ?? false,
                'training_status' => $data['training_status'] ?? false,
            ]);
        });

        return back()->with('success', 'Member updated.');
    }

    public function show(User $member)
    {
        $member->load(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu']);

        return Inertia::render('dashboard/members/Show', [
            'member' => new MemberResource($member),
        ]);
    }

    public function destroy(User $member)
    {
        $member->delete();

        return back()->with('success', 'Member deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['uuid']]);

        User::whereIn('id', $request->ids)->role('member')->delete();

        return back()->with('success', 'Selected members deleted.');
    }

    public function export(Request $request)
    {
        $query = User::query()->role('member')->with('profile');
        $this->applyFilters($query, $request);

        // Hand off to your export class/package of choice, e.g. Laravel Excel
        // return Excel::download(new MembersExport($query), 'members.xlsx');
    }

    protected function applyFilters($query, Request $request): void
    {
        $query
            ->when($request->search, fn ($q, $search) => $q->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', fn ($q) => $q
                        ->where('application_id', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%"));
            }))
            ->when($request->state, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('state_id', $v)))
            ->when($request->zone, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('zone_id', $v)))
            ->when($request->lga, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('lga_id', $v)))
            ->when($request->ward, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('ward_id', $v)))
            ->when($request->status, fn ($q, $v) => $q->where('is_active', $v === 'active'));
    }

    protected function applySort($query, Request $request): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';

        $profileSortable = ['training_status', 'mentor_name', 'application_id'];

        if (in_array($sortBy, $profileSortable, true)) {
            $query->leftJoin('user_profiles', 'user_profiles.user_id', '=', 'users.id')
                ->orderBy("user_profiles.{$sortBy}", $direction)
                ->select('users.*');
            return;
        }

        $sortableOnUsers = ['first_name', 'last_name', 'email', 'is_active', 'created_at'];
        $query->orderBy(in_array($sortBy, $sortableOnUsers, true) ? $sortBy : 'created_at', $direction);
    }

    protected function statistics(): array
    {
        return [
            'total' => User::role('member')->count(),
            'active' => User::role('member')->where('is_active', true)->count(),
            'trained' => User::role('member')->whereHas('profile', fn ($q) => $q->where('training_status', true))->count(),
            'mentored' => User::role('member')->whereHas('profile', fn ($q) => $q->where('mentor_status', true))->count(),
        ];
    }
}