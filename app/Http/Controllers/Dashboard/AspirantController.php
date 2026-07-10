<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\AspirantOffice;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Aspirant\StoreAspirantRequest;
use App\Http\Requests\UpdateAspirantRequest;
use App\Http\Resources\AspirantResource;
use App\Models\Constituency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AspirantController extends Controller
{
    /**
     * Single-profile page for the party's governorship candidate.
     */
    public function governor(Request $request)
    {
        $user = User::query()
            ->whereHas('aspirant', fn ($q) => $q->where('office', AspirantOffice::GOVERNOR->value))
            ->with(['profile.state', 'aspirant.constituency'])
            ->first();

        return Inertia::render('dashboard/aspirants/Governor', [
            'aspirant' => $user ? new AspirantResource($user) : null,
            'formOptions' => [
                'constituencies' => Constituency::orderBy('name')->get(['id', 'name']),
                'offices' => $this->officeOptions(),
            ],
        ]);
    }

    public function index(Request $request)
    {
        $query = User::query()
            ->role(Role::ASPIRANT->value)
            ->with(['profile.state', 'aspirant.constituency']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $aspirants = $query->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return Inertia::render('dashboard/aspirants/Index', [
            'aspirants' => [
                'data' => AspirantResource::collection($aspirants->items()),
                'meta' => [
                    'current_page' => $aspirants->currentPage(),
                    'last_page' => $aspirants->lastPage(),
                    'from' => $aspirants->firstItem(),
                    'to' => $aspirants->lastItem(),
                    'per_page' => $aspirants->perPage(),
                    'total' => $aspirants->total(),
                ],
            ],
            'statistics' => $this->statistics(),
            'filterOptions' => [
                'offices' => $this->officeOptions(),
                'statuses' => [
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'inactive', 'label' => 'Inactive'],
                ],
            ],
            'formOptions' => [
                'constituencies' => Constituency::orderBy('name')->get(['id', 'name']),
                'offices' => $this->officeOptions(),
            ],
            'filters' => $request->only(['search', 'office', 'status']),
        ]);
    }

    public function store(StoreAspirantRequest $request)
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

            $user->assignRole(Role::ASPIRANT->value);

            $user->profile()->create([
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'education_status' => $data['education_status'] ?? null,
            ]);

            $user->aspirant()->create([
                'constituency_id' => $data['constituency_id'],
                'office' => $data['office'],
                'title' => $data['title'] ?? null,
                'vision' => $data['vision'] ?? null,
                'mission' => $data['mission'] ?? null,
                'picture' => $data['image_url'] ?? null,
                'overall_progress' => $data['overall_progress'] ?? 0,
                'total_supporters' => $data['total_supporters'] ?? 0,
                'supporters_growth_this_week' => $data['supporters_growth_this_week'] ?? 0,
                'campaign_team_members' => $data['campaign_team_members'] ?? 0,
            ]);
        });

        return back()->with('success', 'Aspirant created.');
    }

    public function update(UpdateAspirantRequest $request, User $aspirant)
    {
        DB::transaction(function () use ($request, $aspirant) {
            $data = $request->validated();

            $aspirant->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);

            $aspirant->profile()->updateOrCreate(['user_id' => $aspirant->id], [
                'phone' => $data['phone'] ?? null,
                'gender' => $data['gender'] ?? null,
                'education_status' => $data['education_status'] ?? null,
            ]);

            $aspirant->aspirant()->updateOrCreate(['user_id' => $aspirant->id], [
                'constituency_id' => $data['constituency_id'],
                'office' => $data['office'],
                'title' => $data['title'] ?? null,
                'vision' => $data['vision'] ?? null,
                'mission' => $data['mission'] ?? null,
                'picture' => $data['image_url'] ?? null,
                'overall_progress' => $data['overall_progress'] ?? 0,
                'total_supporters' => $data['total_supporters'] ?? 0,
                'supporters_growth_this_week' => $data['supporters_growth_this_week'] ?? 0,
                'campaign_team_members' => $data['campaign_team_members'] ?? 0,
            ]);
        });

        return back()->with('success', 'Aspirant updated.');
    }

    public function show(User $aspirant)
    {
        $aspirant->load(['profile.state', 'aspirant.constituency']);

        return Inertia::render('dashboard/aspirants/Show', [
            'aspirant' => new AspirantResource($aspirant),
        ]);
    }

    public function destroy(User $aspirant)
    {
        $aspirant->delete();

        return back()->with('success', 'Aspirant deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['uuid']]);

        User::whereIn('id', $request->ids)->role(Role::ASPIRANT->value)->delete();

        return back()->with('success', 'Selected aspirants deleted.');
    }

    public function export(Request $request)
    {
        $query = User::query()->role(Role::ASPIRANT->value)->with(['profile', 'aspirant']);
        $this->applyFilters($query, $request);

        // return Excel::download(new AspirantsExport($query), 'aspirants.xlsx');
    }

    protected function applyFilters($query, Request $request): void
    {
        $query
            ->when($request->search, fn ($q, $search) => $q->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->when($request->office, fn ($q, $v) => $q->whereHas('aspirant', fn ($q) => $q->where('office', $v)))
            ->when($request->status, fn ($q, $v) => $q->where('is_active', $v === 'active'));
    }

    protected function applySort($query, Request $request): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'office') {
            $query->leftJoin('aspirants', 'aspirants.user_id', '=', 'users.id')
                ->orderBy('aspirants.office', $direction)
                ->select('users.*');
            return;
        }

        $sortableOnUsers = ['first_name', 'last_name', 'email', 'is_active', 'created_at'];
        $query->orderBy(in_array($sortBy, $sortableOnUsers, true) ? $sortBy : 'created_at', $direction);
    }

    protected function statistics(): array
    {
        $base = User::role(Role::ASPIRANT->value);

        return [
            'total' => (clone $base)->count(),
            'active' => (clone $base)->where('is_active', true)->count(),
            'governor' => (clone $base)->whereHas('aspirant', fn ($q) => $q->where('office', AspirantOffice::GOVERNOR->value))->count(),
            'constituencies' => (clone $base)->whereHas('aspirant')
                ->join('aspirants', 'aspirants.user_id', '=', 'users.id')
                ->distinct('aspirants.constituency_id')
                ->count('aspirants.constituency_id'),
        ];
    }

    protected function officeOptions(): array
    {
        return collect(AspirantOffice::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => ucwords(str_replace('_', ' ', strtolower($case->value))),
            ])
            ->values()
            ->all();
    }
}