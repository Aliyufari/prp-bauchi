<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PartyAgentType;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartyAgent\StorePartyAgentRequest;
use App\Http\Requests\PartyAgent\UpdatePartyAgentRequest;
use App\Http\Resources\PartyAgentResource;
use App\Models\Lga;
use App\Models\PartyAgent;
use App\Models\Pu;
use App\Models\State;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PartyAgentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->role(Role::PARTY_AGENT->value)
            ->with(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'partyAgent']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $agents = $query->paginate($request->integer('per_page', 15))
            ->withQueryString();

        return Inertia::render('dashboard/party-agents/Index', [
            'agents' => [
                'data' => PartyAgentResource::collection($agents->items()),
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

    public function store(StorePartyAgentRequest $request)
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

            $user->assignRole(Role::PARTY_AGENT->value);

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

            $user->partyAgent()->create([
                'type' => $data['type'],
            ]);
        });

        return back()->with('success', 'Party agent created.');
    }

    public function update(UpdatePartyAgentRequest $request, User $party_agent)
    {
        DB::transaction(function () use ($request, $party_agent) {
            $data = $request->validated();

            $party_agent->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                ...(!empty($data['password']) ? ['password' => Hash::make($data['password'])] : []),
            ]);

            $party_agent->profile()->updateOrCreate(['user_id' => $party_agent->id], [
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

            $party_agent->partyAgent()->updateOrCreate(['user_id' => $party_agent->id], [
                'type' => $data['type'],
            ]);
        });

        return back()->with('success', 'Party agent updated.');
    }

    public function show(User $party_agent)
    {
        $party_agent->load(['profile.state', 'profile.zone', 'profile.lga', 'profile.ward', 'profile.pu', 'partyAgent']);

        return Inertia::render('dashboard/party-agents/Show', [
            'agent' => new PartyAgentResource($party_agent),
        ]);
    }

    public function destroy(User $party_agent)
    {
        $party_agent->delete();

        return back()->with('success', 'Party agent deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['uuid']]);

        User::whereIn('id', $request->ids)->role(Role::PARTY_AGENT->value)->delete();

        return back()->with('success', 'Selected party agents deleted.');
    }

    public function export(Request $request)
    {
        $query = User::query()->role(Role::PARTY_AGENT->value)->with(['profile', 'partyAgent']);
        $this->applyFilters($query, $request);

        // Hand off to your export class of choice, e.g. Laravel Excel
        // return Excel::download(new PartyAgentsExport($query), 'party-agents.xlsx');
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
            ->when($request->type, fn ($q, $v) => $q->whereHas('partyAgent', fn ($q) => $q->where('type', $v)));
    }

    protected function applySort($query, Request $request): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('sort_direction', 'desc') === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'agent_type') {
            $query->leftJoin('party_agents', 'party_agents.user_id', '=', 'users.id')
                ->orderBy('party_agents.type', $direction)
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
        $base = User::role(Role::PARTY_AGENT->value);

        return [
            'total' => (clone $base)->count(),
            'active' => (clone $base)->where('is_active', true)->count(),
            'deployed' => (clone $base)->whereHas('profile', fn ($q) => $q->whereNotNull('pu_id'))->count(),
            'unassigned' => (clone $base)->whereDoesntHave('profile', fn ($q) => $q->whereNotNull('pu_id'))->count(),
        ];
    }

    protected function typeOptions(): array
    {
        return collect(PartyAgentType::cases())
            ->map(fn ($case) => [
                'value' => $case->value,
                'label' => ucwords(str_replace('_', ' ', strtolower($case->value))),
            ])
            ->values()
            ->all();
    }
}