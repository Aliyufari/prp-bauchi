<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Role;
use App\Enums\StakeholderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStakeholderRequest;
use App\Http\Requests\UpdateStakeholderRequest;
use App\Http\Resources\StakeholderResource;
use App\Models\Lga;
use App\Models\Pu;
use App\Models\State;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class StakeholderController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->role(Role::STAKEHOLDER->value)
            ->with(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'stakeholder']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $stakeholders = $query->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return Inertia::render('dashboard/stakeholders/Index', [
            'stakeholders' => [
                'data' => StakeholderResource::collection($stakeholders->items()),
                'meta' => [
                    'current_page' => $stakeholders->currentPage(),
                    'last_page' => $stakeholders->lastPage(),
                    'from' => $stakeholders->firstItem(),
                    'to' => $stakeholders->lastItem(),
                    'per_page' => $stakeholders->perPage(),
                    'total' => $stakeholders->total(),
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
                'types' => $this->typeOptions(),
            ],
            'formOptions' => [
                'states' => State::orderBy('name')->get(['id', 'name']),
                'zones' => Zone::orderBy('name')->get(['id', 'name']),
                'lgas' => Lga::orderBy('name')->get(['id', 'name']),
                'wards' => Ward::orderBy('name')->get(['id', 'name']),
                'pus' => Pu::orderBy('name')->get(['id', 'name']),
                'types' => $this->typeOptions(),
            ],
            'filters' => $request->only(['search', 'state', 'zone', 'lga', 'ward', 'status', 'type']),
        ]);
    }

    public function store(StoreStakeholderRequest $request)
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

            $user->assignRole(Role::STAKEHOLDER->value);

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
            ]);

            $user->stakeholder()->create([
                'type' => $data['type'],
                'organization' => $data['organization'] ?? null,
                'designation' => $data['designation'] ?? null,
            ]);
        });

        return back()->with('success', 'Stakeholder created.');
    }

    public function update(UpdateStakeholderRequest $request, User $stakeholder)
    {
        DB::transaction(function () use ($request, $stakeholder) {
            $data = $request->validated();

            $stakeholder->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);

            $stakeholder->profile()->updateOrCreate(['user_id' => $stakeholder->id], [
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
            ]);

            $stakeholder->stakeholder()->updateOrCreate(['user_id' => $stakeholder->id], [
                'type' => $data['type'],
                'organization' => $data['organization'] ?? null,
                'designation' => $data['designation'] ?? null,
            ]);
        });

        return back()->with('success', 'Stakeholder updated.');
    }

    public function show(User $stakeholder)
    {
        $stakeholder->load(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'stakeholder']);

        return Inertia::render('dashboard/stakeholders/Show', [
            'stakeholder' => new StakeholderResource($stakeholder),
        ]);
    }

    public function destroy(User $stakeholder)
    {
        $stakeholder->delete();

        return back()->with('success', 'Stakeholder deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['uuid']]);

        User::whereIn('id', $request->ids)->role(Role::STAKEHOLDER->value)->delete();

        return back()->with('success', 'Selected stakeholders deleted.');
    }

    public function export(Request $request)
    {
        $query = User::query()->role(Role::STAKEHOLDER->value)->with(['profile', 'stakeholder']);
        $this->applyFilters($query, $request);

        // return Excel::download(new StakeholdersExport($query), 'stakeholders.xlsx');
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
                        ->orWhere('phone', 'like', "%{$search}%"))
                    ->orWhereHas('stakeholder', fn ($q) => $q
                        ->where('organization', 'like', "%{$search}%"));
            }))
            ->when($request->state, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('state_id', $v)))
            ->when($request->zone, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('zone_id', $v)))
            ->when($request->lga, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('lga_id', $v)))
            ->when($request->ward, fn ($q, $v) => $q->whereHas('profile', fn ($q) => $q->where('ward_id', $v)))
            ->when($request->status, fn ($q, $v) => $q->where('is_active', $v === 'active'))
            ->when($request->type, fn ($q, $v) => $q->whereHas('stakeholder', fn ($q) => $q->where('type', $v)));
    }

    protected function applySort($query, Request $request): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'stakeholder_type') {
            $query->leftJoin('stakeholders', 'stakeholders.user_id', '=', 'users.id')
                ->orderBy('stakeholders.type', $direction)
                ->select('users.*');
            return;
        }

        if (in_array($sortBy, ['application_id'], true)) {
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
        $base = User::role(Role::STAKEHOLDER->value);

        return [
            'total' => (clone $base)->count(),
            'active' => (clone $base)->where('is_active', true)->count(),
            'traditional_rulers' => (clone $base)->whereHas('stakeholder', fn ($q) => $q->where('type', StakeholderType::TRADITIONAL_RULER))->count(),
            'organizations' => (clone $base)->whereHas('stakeholder', fn ($q) => $q->whereNotNull('organization'))->count(),
        ];
    }

    protected function typeOptions(): array
    {
        return collect(StakeholderType::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => ucwords(str_replace('_', ' ', strtolower($case->value))),
            ])
            ->values()
            ->all();
    }
}