<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Role;
use App\Enums\SupervisoryAgentType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupervisoryAgentRequest;
use App\Http\Requests\UpdateSupervisoryAgentRequest;
use App\Http\Resources\SupervisoryAgentResource;
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

class SupervisoryAgentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->role(Role::SUPERVISORY_AGENT->value)
            ->with(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'supervisoryAgent']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $agents = $query->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return Inertia::render('dashboard/supervisory-agents/Index', [
            'agents' => [
                'data' => SupervisoryAgentResource::collection($agents->items()),
                'meta' => [
                    'current_page' => $agents->currentPage(),
                    'last_page' => $agents->lastPage(),
                    'from' => $agents->firstItem(),
                    'to' => $agents->lastItem(),
                    'per_page' => $agents->perPage(),
                    'total' => $agents->total(),
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

    public function store(StoreSupervisoryAgentRequest $request)
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

            $user->assignRole(Role::SUPERVISORY_AGENT->value);

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

            $user->supervisoryAgent()->create([
                'type' => $data['type'],
                'agents_supervised' => $data['agents_supervised'] ?? 0,
            ]);
        });

        return back()->with('success', 'Supervisory agent created.');
    }

    public function update(UpdateSupervisoryAgentRequest $request, User $supervisory_agent)
    {
        DB::transaction(function () use ($request, $supervisory_agent) {
            $data = $request->validated();

            $supervisory_agent->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);

            $supervisory_agent->profile()->updateOrCreate(['user_id' => $supervisory_agent->id], [
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

            $supervisory_agent->supervisoryAgent()->updateOrCreate(['user_id' => $supervisory_agent->id], [
                'type' => $data['type'],
                'agents_supervised' => $data['agents_supervised'] ?? 0,
            ]);
        });

        return back()->with('success', 'Supervisory agent updated.');
    }

    public function show(User $supervisory_agent)
    {
        $supervisory_agent->load(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'supervisoryAgent']);

        return Inertia::render('dashboard/supervisory-agents/Show', [
            'agent' => new SupervisoryAgentResource($supervisory_agent),
        ]);
    }

    public function destroy(User $supervisory_agent)
    {
        $supervisory_agent->delete();

        return back()->with('success', 'Supervisory agent deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['uuid']]);

        User::whereIn('id', $request->ids)->role(Role::SUPERVISORY_AGENT->value)->delete();

        return back()->with('success', 'Selected supervisory agents deleted.');
    }

    public function export(Request $request)
    {
        $query = User::query()->role(Role::SUPERVISORY_AGENT->value)->with(['profile', 'supervisoryAgent']);
        $this->applyFilters($query, $request);

        // return Excel::download(new SupervisoryAgentsExport($query), 'supervisory-agents.xlsx');
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
            ->when($request->type, fn ($q, $v) => $q->whereHas('supervisoryAgent', fn ($q) => $q->where('type', $v)));
    }

    protected function applySort($query, Request $request): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';

        if (in_array($sortBy, ['supervisor_type', 'agents_supervised'], true)) {
            $column = $sortBy === 'supervisor_type' ? 'type' : 'agents_supervised';
            $query->leftJoin('supervisory_agents', 'supervisory_agents.user_id', '=', 'users.id')
                ->orderBy("supervisory_agents.{$column}", $direction)
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
        $base = User::role(Role::SUPERVISORY_AGENT->value);

        return [
            'total' => (clone $base)->count(),
            'active' => (clone $base)->where('is_active', true)->count(),
            'total_agents_supervised' => (int) (clone $base)
                ->join('supervisory_agents', 'supervisory_agents.user_id', '=', 'users.id')
                ->sum('supervisory_agents.agents_supervised'),
            'unassigned' => (clone $base)->whereDoesntHave('profile', fn ($q) => $q->whereNotNull('lga_id'))->count(),
        ];
    }

    protected function typeOptions(): array
    {
        return collect(SupervisoryAgentType::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => ucwords(str_replace('_', ' ', strtolower($case->value))),
            ])
            ->values()
            ->all();
    }
}