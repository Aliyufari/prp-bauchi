<?php

namespace Database\Seeders;

use App\Enums\AspirantOffice;
use App\Enums\CoordinatorType;
use App\Enums\EducationStatus;
use App\Enums\Gender;
use App\Enums\PartyAgentType;
use App\Enums\Role;
use App\Enums\StakeholderType;
use App\Enums\SupervisoryAgentType;
use App\Models\Constituency;
use App\Models\Coordinator;
use App\Models\Lga;
use App\Models\PartyAgent;
use App\Models\ReturningOfficer;
use App\Models\Stakeholder;
use App\Models\State;
use App\Models\SupervisoryAgent;
use App\Models\User;
use App\Models\Ward;
use App\Models\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected array $states;
    protected array $zones;
    protected array $lgas;
    protected array $wards;
    protected array $constituencies;

    public function run(): void
    {
        // Pre-load location chains once, so every seeded record can cycle
        // through real rows instead of everything pointing at ::first().
        $this->states = State::all()->all();
        $this->zones = Zone::all()->all();
        $this->lgas = Lga::all()->all();
        $this->wards = Ward::all()->all();
        $this->constituencies = Constituency::all()->all();

        $this->seedSuperAdmins();
        $this->seedAdmin();
        $this->seedMembers();
        $this->seedCoordinators();
        $this->seedPartyAgents();
        $this->seedReturningOfficers();
        $this->seedAspirants();
        $this->seedStakeholders();
        $this->seedSupervisoryAgents();
    }

    /* ---------------------------------------------------------------- */
    /* Super Admins (2)                                                  */
    /* ---------------------------------------------------------------- */
    protected function seedSuperAdmins(): void
    {
        $admins = [
            ['first' => 'Aliyu', 'last' => 'Sadisu', 'email' => 'aslere00005@gmail.com', 'password' => 'Aslere00005'],
            ['first' => 'Aliyu', 'last' => 'Abubakar', 'email' => 'aliyufari@gmail.com', 'password' => 'Fari@3031.'],
        ];

        foreach ($admins as $i => $admin) {
            $user = User::create([
                'first_name' => $admin['first'],
                'last_name' => $admin['last'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password']),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::SUPER_ADMIN->value);

            $user->profile()->create([
                'phone' => '0801000000' . $i,
                'gender' => Gender::MALE->value,
                'occupation' => 'System Administrator',
                'education_status' => EducationStatus::MSC->value,
                'training_status' => true,
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Admin (1)                                                         */
    /* ---------------------------------------------------------------- */
    protected function seedAdmin(): void
    {
        $admin = User::create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@prp.test',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole(Role::ADMIN->value);

        $admin->profile()->create([
            'phone' => '08010000003',
            'gender' => Gender::MALE->value,
            'occupation' => 'Administrator',
            'education_status' => EducationStatus::BSC->value,
            'training_status' => true,
        ]);
    }

    /* ---------------------------------------------------------------- */
    /* Members (10)                                                      */
    /* ---------------------------------------------------------------- */
    protected function seedMembers(): void
    {
        $firstNames = ['Aliyu', 'Fatima', 'Musa', 'Zainab', 'Ibrahim', 'Amina', 'Suleiman', 'Hauwa', 'Yakubu', 'Maryam'];
        $lastNames = ['Yusuf', 'Bello', 'Abdullahi', 'Sani', 'Garba', 'Usman', 'Adamu', 'Idris', 'Lawal', 'Umar'];
        $occupations = ['Teacher', 'Trader', 'Farmer', 'Civil Servant', 'Driver', 'Tailor', 'Nurse', 'Mechanic', 'Student', 'Business Owner'];

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "member{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::MEMBER->value);

            $user->profile()->create([
                'phone' => '0803000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'occupation' => $occupations[$i - 1],
                'education_status' => EducationStatus::BSC->value,
                'training_status' => $i % 2 === 0,
                'mentor_status' => $i % 3 === 0,
                'mentor_name' => $i % 3 === 0 ? 'Ibrahim Musa' : null,
                'application_id' => 'PRP' . str_pad((string) $i, 6, '0', STR_PAD_LEFT),
                'state_id' => $this->pick($this->states)?->id,
                'zone_id' => $this->pick($this->zones)?->id,
                'lga_id' => $this->pick($this->lgas)?->id,
                'ward_id' => $this->pick($this->wards)?->id,
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Coordinators (10)                                                 */
    /* ---------------------------------------------------------------- */
    protected function seedCoordinators(): void
    {
        $firstNames = ['Ahmed', 'Blessing', 'Chidi', 'Deborah', 'Emeka', 'Fatimah', 'Godwin', 'Halima', 'Isah', 'Joy'];
        $lastNames = ['Coordinator', 'Danjuma', 'Okafor', 'Suleman', 'Nwosu', 'Aliyu', 'Eze', 'Bawa', 'Ogundele', 'Musa'];
        $types = CoordinatorType::cases();

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "coordinator{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::COORDINATOR->value);

            $user->profile()->create([
                'phone' => '0804000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'occupation' => 'Civil Servant',
                'education_status' => EducationStatus::BSC->value,
                'training_status' => true,
                'state_id' => $this->pick($this->states)?->id,
                'zone_id' => $this->pick($this->zones)?->id,
                'lga_id' => $this->pick($this->lgas)?->id,
                'ward_id' => $this->pick($this->wards)?->id,
            ]);

            Coordinator::create([
                'user_id' => $user->id,
                'type' => $types[($i - 1) % count($types)]->value,
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Party Agents (10)                                                 */
    /* ---------------------------------------------------------------- */
    protected function seedPartyAgents(): void
    {
        $firstNames = ['Umar', 'Ngozi', 'Kabiru', 'Patience', 'Rilwan', 'Sadiya', 'Tunde', 'Uchenna', 'Vera', 'Wasiu'];
        $lastNames = ['Agent', 'Bassey', 'Danlami', 'Ekong', 'Falade', 'Gambo', 'Haruna', 'Ibeh', 'Jibril', 'Kalu'];
        $types = PartyAgentType::cases();

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "agent{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::PARTY_AGENT->value);

            $user->profile()->create([
                'phone' => '0805000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'education_status' => EducationStatus::SECONDARY->value,
                'state_id' => $this->pick($this->states)?->id,
                'zone_id' => $this->pick($this->zones)?->id,
                'lga_id' => $this->pick($this->lgas)?->id,
                'ward_id' => $this->pick($this->wards)?->id,
                // Roughly half "deployed" to a polling unit, half not,
                // to give the Members/Party Agents dashboard some spread.
                'pu_id' => null,
            ]);

            PartyAgent::create([
                'user_id' => $user->id,
                'type' => $types[($i - 1) % count($types)]->value,
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Returning Officers (10)                                           */
    /* ---------------------------------------------------------------- */
    protected function seedReturningOfficers(): void
    {
        $firstNames = ['Xavier', 'Yetunde', 'Zainab', 'Ahmadu', 'Bilkisu', 'Chuka', 'Damilola', 'Efe', 'Gimba', 'Hadiza'];
        $lastNames = ['Officer', 'Ilori', 'Jatau', 'Kwaghfan', 'Lami', 'Mbah', 'Nuhu', 'Ojo', 'Pam', 'Rufai'];
        $institutions = ['INEC', 'INEC', 'State Electoral Office', 'INEC', 'Local Government Electoral Committee'];
        $postings = ['Bauchi', 'Toro', 'Ningi', 'Misau', 'Azare', 'Jama\'are', 'Katagum', 'Dass', 'Tafawa Balewa', 'Alkaleri'];

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "officer{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::RETURNING_OFFICER->value);

            $user->profile()->create([
                'phone' => '0806000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'education_status' => EducationStatus::MSC->value,
                'state_id' => $this->pick($this->states)?->id,
                'zone_id' => $this->pick($this->zones)?->id,
                'lga_id' => $this->pick($this->lgas)?->id,
                'ward_id' => $this->pick($this->wards)?->id,
            ]);

            ReturningOfficer::create([
                'user_id' => $user->id,
                'institution' => $institutions[($i - 1) % count($institutions)],
                'posting_location' => $postings[$i - 1],
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Aspirants (10 — one Governor, rest spread across other offices)   */
    /* ---------------------------------------------------------------- */
    protected function seedAspirants(): void
    {
        if (empty($this->constituencies)) {
            $this->command?->warn(
                'Skipped seeding Aspirants: no Constituency rows exist. '
                . 'Seed constituencies before UserSeeder to populate these records.'
            );
            return;
        }

        $firstNames = ['Governorship', 'Ibrahim', 'Chinwe', 'Danladi', 'Esther', 'Farouk', 'Grace', 'Habib', 'Ifeoma', 'Junaid'];
        $lastNames = ['Candidate', 'Shehu', 'Okonkwo', 'Yahaya', 'Bature', 'Adeyemi', 'Danburam', 'Nasiru', 'Chukwu', 'Abba'];
        $offices = array_values(array_filter(
            AspirantOffice::cases(),
            fn ($case) => $case !== AspirantOffice::GOVERNOR
        ));

        for ($i = 1; $i <= 10; $i++) {
            $isGovernor = $i === 1;

            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "aspirant{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::ASPIRANT->value);

            $user->profile()->create([
                'phone' => '0807000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'education_status' => EducationStatus::MSC->value,
                'state_id' => $this->pick($this->states)?->id,
            ]);

            $user->aspirant()->create([
                'constituency_id' => $this->pick($this->constituencies)->id,
                'office' => $isGovernor
                    ? AspirantOffice::GOVERNOR->value
                    : $offices[($i - 2) % count($offices)]->value,
                'title' => $isGovernor ? 'Governorship Candidate, Bauchi State' : null,
                'vision' => $isGovernor ? 'A prosperous, secure, and inclusive Bauchi State for all.' : null,
                'mission' => $isGovernor ? 'To deliver transparent governance, economic growth, and equal opportunity across all 20 LGAs.' : null,
                'overall_progress' => $isGovernor ? 62 : 0,
                'total_supporters' => $isGovernor ? 48210 : 0,
                'supporters_growth_this_week' => $isGovernor ? 1340 : 0,
                'campaign_team_members' => $isGovernor ? 86 : 0,
                'avatar' => null,
                'picture' => null,
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Stakeholders (10)                                                 */
    /* ---------------------------------------------------------------- */
    protected function seedStakeholders(): void
    {
        $firstNames = ['Alhaji', 'Hajiya', 'Danjuma', 'Rakiya', 'Emir', 'Sarki', 'Baba', 'Iya', 'Malam', 'Mallama'];
        $lastNames = ['Bakori', 'Dahiru', 'Wakili', 'Gambo', 'Mustapha', 'Yola', 'Zubairu', 'Adamu', 'Sale', 'Tanko'];
        $organizations = ['Emirate Council', 'Bauchi Youth Forum', 'Women Development Initiative', 'Chamber of Commerce', 'Council of Imams'];
        $types = StakeholderType::cases();

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "stakeholder{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::STAKEHOLDER->value);

            $user->profile()->create([
                'phone' => '0808000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'education_status' => EducationStatus::BSC->value,
                'state_id' => $this->pick($this->states)?->id,
                'zone_id' => $this->pick($this->zones)?->id,
                'lga_id' => $this->pick($this->lgas)?->id,
                'ward_id' => $this->pick($this->wards)?->id,
            ]);

            Stakeholder::create([
                'user_id' => $user->id,
                'type' => $types[($i - 1) % count($types)]->value,
                'organization' => $organizations[($i - 1) % count($organizations)],
                'designation' => 'Chairman',
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Supervisory Agents (10)                                           */
    /* ---------------------------------------------------------------- */
    protected function seedSupervisoryAgents(): void
    {
        $firstNames = ['Kenneth', 'Larai', 'Muktar', 'Ngozi', 'Obinna', 'Peace', 'Quadri', 'Rebecca', 'Sadiq', 'Titi'];
        $lastNames = ['Supervisor', 'Danladi', 'Ekpo', 'Fagbenle', 'Garba', 'Haruna', 'Isyaku', 'Joseph', 'Kolo', 'Lami'];
        $types = SupervisoryAgentType::cases();

        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'first_name' => $firstNames[$i - 1],
                'last_name' => $lastNames[$i - 1],
                'email' => "supervisor{$i}@prp.test",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(Role::SUPERVISORY_AGENT->value);

            $user->profile()->create([
                'phone' => '0809000' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? Gender::FEMALE->value : Gender::MALE->value,
                'education_status' => EducationStatus::BSC->value,
                'state_id' => $this->pick($this->states)?->id,
                'zone_id' => $this->pick($this->zones)?->id,
                'lga_id' => $this->pick($this->lgas)?->id,
                'ward_id' => $this->pick($this->wards)?->id,
            ]);

            SupervisoryAgent::create([
                'user_id' => $user->id,
                'type' => $types[($i - 1) % count($types)]->value,
                'agents_supervised' => rand(3, 15),
            ]);
        }
    }

    /* ---------------------------------------------------------------- */
    /* Helper                                                            */
    /* ---------------------------------------------------------------- */
    protected function pick(array $items): mixed
    {
        return empty($items) ? null : $items[array_rand($items)];
    }
}