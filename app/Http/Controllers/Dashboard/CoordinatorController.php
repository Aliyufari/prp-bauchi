<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\CoordinatorType;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\StoreCoordinatorRequest;
use App\Http\Requests\Coordinator\UpdateCoordinatorRequest;
use App\Http\Resources\CoordinatorResource;
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

class CoordinatorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->role(Role::COORDINATOR->value)
            ->with(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'coordinator']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $coordinators = $query->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return Inertia::render('dashboard/coordinators/Index', [
            'coordinators' => [
                'data' => CoordinatorResource::collection($coordinators->items()),
                'meta' => [
                    'current_page' => $coordinators->currentPage(),
                    'last_page' => $coordinators->lastPage(),
                    'from' => $coordinators->firstItem(),
                    'to' => $coordinators->lastItem(),
                    'per_page' => $coordinators->perPage(),
                    'total' => $coordinators->total(),
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

    public function store(StoreCoordinatorRequest $request)
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

            $user->assignRole(Role::COORDINATOR->value);

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

            $user->coordinator()->create([
                'type' => $data['type'],
            ]);
        });

        return back()->with('success', 'Coordinator created.');
    }

    public function update(UpdateCoordinatorRequest $request, User $coordinator)
    {
        DB::transaction(function () use ($request, $coordinator) {
            $data = $request->validated();

            $coordinator->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);

            $coordinator->profile()->updateOrCreate(['user_id' => $coordinator->id], [
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

            $coordinator->coordinator()->updateOrCreate(['user_id' => $coordinator->id], [
                'type' => $data['type'],
            ]);
        });

        return back()->with('success', 'Coordinator updated.');
    }

    public function show(User $coordinator)
    {
        $coordinator->load(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'coordinator']);

        return Inertia::render('dashboard/coordinators/Show', [
            'coordinator' => new CoordinatorResource($coordinator),
        ]);
    }

    public function destroy(User $coordinator)
    {
        $coordinator->delete();

        return back()->with('success', 'Coordinator deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['uuid']]);

        User::whereIn('id', $request->ids)->role(Role::COORDINATOR->value)->delete();

        return back()->with('success', 'Selected coordinators deleted.');
    }

    public function export(Request $request)
    {
        $query = User::query()->role(Role::COORDINATOR->value)->with(['profile', 'coordinator']);
        $this->applyFilters($query, $request);

        // Hand off to your export class of choice, e.g. Laravel Excel
        // return Excel::download(new CoordinatorsExport($query), 'coordinators.xlsx');
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
            ->when($request->status, fn ($q, $v) => $q->where('is_active', $v === 'active'))
            ->when($request->type, fn ($q, $v) => $q->whereHas('coordinator', fn ($q) => $q->where('type', $v)));
    }

    protected function applySort($query, Request $request): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'coordinator_type') {
            $query->leftJoin('coordinators', 'coordinators.user_id', '=', 'users.id')
                ->orderBy('coordinators.type', $direction)
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
        $base = User::role(Role::COORDINATOR->value);

        return [
            'total' => (clone $base)->count(),
            'active' => (clone $base)->where('is_active', true)->count(),
            'state_level' => (clone $base)->whereHas('coordinator', fn ($q) => $q->where('type', CoordinatorType::STATE_COORDINATOR))->count(),
            'assigned' => (clone $base)->whereHas('profile', fn ($q) => $q->whereNotNull('lga_id'))->count(),
        ];
    }

    protected function typeOptions(): array
    {
        return collect(CoordinatorType::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => ucwords(str_replace('_', ' ', strtolower($case->value))),
            ])
            ->values()
            ->all();
    }
}