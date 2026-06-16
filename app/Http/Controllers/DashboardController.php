<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => $this->getStats(),
            'membershipByLga' => $this->getMembershipByLga(),
            'campaignActivities' => $this->getCampaignActivities(),
            'upcomingActivities' => $this->getUpcomingActivities(),
            'electionStrategyActivities' => $this->getElectionStrategyActivities(),
            'lgaSupportData' => $this->getLgaSupportData(),
            'aspirant' => $this->getAspirant(),
            'agentDeployment' => $this->getAgentDeployment(),
            'financialSummary' => $this->getFinancialSummary(),
            'announcements' => $this->getAnnouncements(),
            'recentSupporters' => $this->getRecentSupporters(),
            'lgas' => $this->getLgas(),
            'wards' => $this->getWards(),
            'selectedLga' => $request->input('lga', ''),
            'selectedWard' => $request->input('ward', ''),
        ]);
    }

    private function getStats(): array
    {
        return [
            'totalMembers' => 32540,
            'totalMembersGrowth' => 12.5,
            'partyAgents' => 2350,
            'partyAgentsGrowth' => 8.3,
            'coordinators' => 285,
            'coordinatorsGrowth' => 5.6,
            'stakeholders' => 1024,
            'stakeholdersGrowth' => 7.2,
            'upcomingActivities' => 18,
            'lgasCovered' => 20,
            'totalLgas' => 20,
        ];
    }

    private function getMembershipByLga(): array
    {
        $lgas = [
            'Alkaleri', 'Toro', 'Bogoro', 'Kirfi', 'Darazo',
            'Dass', 'Ganjuwa', 'Itas', 'Katagum', 'Ningi',
            'Misau', 'Shira', 'Tafawa', 'Bauchi', 'Gamawa',
            'Giade', "Jama'are", 'Dambam', 'Warji', 'Zaki',
        ];

        return collect($lgas)->map(fn ($lga) => [
            'lga' => $lga,
            'count' => rand(800, 3800),
        ])->toArray();
    }

    private function getCampaignActivities(): array
    {
        return [
            ['name' => 'Mobilization & Sensitization', 'percentage' => 30, 'color' => '#15803d'],
            ['name' => 'Door to Door Campaign', 'percentage' => 20, 'color' => '#1d4ed8'],
            ['name' => 'Town Hall Meetings', 'percentage' => 15, 'color' => '#7c3aed'],
            ['name' => 'Media & Publicity', 'percentage' => 15, 'color' => '#d97706'],
            ['name' => 'Stakeholder Engagement', 'percentage' => 10, 'color' => '#dc2626'],
            ['name' => 'Voter Education', 'percentage' => 10, 'color' => '#0891b2'],
        ];
    }

    private function getUpcomingActivities(): array
    {
        return [
            [
                'date' => 'MAY 25',
                'month' => 'MAY',
                'day' => 25,
                'title' => 'State Executive Meeting',
                'location' => 'PRP Secretariat, Bauchi',
                'time' => '10:00 AM',
            ],
            [
                'date' => 'MAY 26',
                'month' => 'MAY',
                'day' => 26,
                'title' => 'Mega Rally in Bauchi LGA',
                'location' => 'Bauchi Township Stadium',
                'time' => '11:00 AM',
            ],
            [
                'date' => 'MAY 27',
                'month' => 'MAY',
                'day' => 27,
                'title' => 'Door to Door Campaign',
                'location' => 'Ningi LGA',
                'time' => 'All Day',
                'isAllDay' => true,
            ],
            [
                'date' => 'MAY 28',
                'month' => 'MAY',
                'day' => 28,
                'title' => 'Town Hall Meeting',
                'location' => 'Misau LGA',
                'time' => '04:00 PM',
            ],
            [
                'date' => 'MAY 29',
                'month' => 'MAY',
                'day' => 29,
                'title' => 'Youth Empowerment Program',
                'location' => 'Toro LGA',
                'time' => '10:00 AM',
            ],
        ];
    }

    private function getElectionStrategyActivities(): array
    {
        return [
            [
                'id' => 1,
                'icon' => 'Megaphone',
                'title' => 'Mass Mobilization',
                'description' => 'Rallies, roadshows, and community meetings',
                'status' => 'Ongoing',
            ],
            [
                'id' => 2,
                'icon' => 'DoorOpen',
                'title' => 'Door to Door Campaign',
                'description' => 'House to house engagement with voters',
                'status' => 'Ongoing',
            ],
            [
                'id' => 3,
                'icon' => 'BookOpen',
                'title' => 'Voter Education',
                'description' => 'Educate voters on PRP vision and policies',
                'status' => 'Ongoing',
            ],
            [
                'id' => 4,
                'icon' => 'Baby',
                'title' => 'Youth & Women Mobilization',
                'description' => 'Empower and engage youth and women',
                'status' => 'Ongoing',
            ],
            [
                'id' => 5,
                'icon' => 'Handshake',
                'title' => 'Stakeholder Engagement',
                'description' => 'Engage traditional rulers, leaders, and influencers',
                'status' => 'Ongoing',
            ],
            [
                'id' => 6,
                'icon' => 'Star',
                'title' => 'Media & Publicity',
                'description' => 'Radio, TV, Social Media and print media campaigns',
                'status' => 'Ongoing',
            ],
            [
                'id' => 7,
                'icon' => 'Eye',
                'title' => 'Election Monitoring',
                'description' => 'Monitor polling units and protect votes',
                'status' => 'Planned',
            ],
            [
                'id' => 8,
                'icon' => 'Database',
                'title' => 'War Room & Data Center',
                'description' => 'Real-time data collection and analysis',
                'status' => 'Ongoing',
            ],
        ];
    }

    private function getLgaSupportData(): array
    {
        $lgas = [
            'Alkaleri', 'Bauchi', 'Bogoro', 'Dambam', 'Darazo',
            'Dass', 'Gamawa', 'Ganjuwa', 'Giade', 'Itas/Gadau',
            "Jama'are", 'Katagum', 'Kirfi', 'Misau', 'Ningi',
            'Shira', 'Tafawa Balewa', 'Toro', 'Warji', 'Zaki',
        ];

        $levels = ['high', 'high', 'medium', 'low', 'high', 'medium',
            'high', 'medium', 'low', 'medium', 'high', 'low',
            'high', 'medium', 'high', 'low', 'medium', 'high', 'low', 'medium'];

        return collect($lgas)->map(fn ($lga, $i) => [
            'lga' => $lga,
            'supportLevel' => $levels[$i],
        ])->toArray();
    }

    private function getAspirant(): array
    {
        return [
            'name' => 'Alh. Usman Mohammed',
            'title' => 'PRP Governorship Aspirant',
            'state' => 'Bauchi State',
            'vision' => 'A united, peaceful and prosperous Bauchi State.',
            'mission' => 'Good governance, youth empowerment and people centered development.',
            'imageUrl' => '',
            'overallProgress' => 68,
            'totalSupporters' => 24560,
            'supportersGrowthThisWeek' => 1250,
            'campaignTeamMembers' => 320,
        ];
    }

    private function getAgentDeployment(): array
    {
        return [
            'deployed' => 1850,
            'deployedPct' => 79,
            'unassigned' => 300,
            'unassignedPct' => 13,
            'awaitingTraining' => 200,
            'awaitingTrainingPct' => 8,
            'total' => 2350,
        ];
    }

    private function getFinancialSummary(): array
    {
        return [
            'totalDonations' => 45600000,
            'donationsGrowth' => 18,
            'totalExpenditures' => 12750000,
            'expendituresGrowth' => 10,
            'balance' => 32850000,
            'balanceGrowth' => 20,
        ];
    }

    private function getAnnouncements(): array
    {
        return [
            ['id' => 1, 'title' => 'Stakeholders Meeting Rescheduled', 'date' => 'May 25, 2024'],
            ['id' => 2, 'title' => 'New Ward Coordinators Appointed', 'date' => 'May 24, 2024'],
            ['id' => 3, 'title' => 'Campaign Rally in Darazo LGA', 'date' => 'May 23, 2024'],
        ];
    }

    private function getRecentSupporters(): array
    {
        return [
            ['id' => 1, 'name' => 'Alh. Ahmed Garba', 'lga' => 'Bauchi LGA', 'amount' => 500000, 'imageUrl' => ''],
            ['id' => 2, 'name' => 'Hajiya Aisha Ibrahim', 'lga' => 'Misau LGA', 'amount' => 300000, 'imageUrl' => ''],
            ['id' => 3, 'name' => 'Hon. Saleh Mohammed', 'lga' => 'Toro LGA', 'amount' => 250000, 'imageUrl' => ''],
        ];
    }

    private function getLgas(): array
    {
        return [
            'Alkaleri', 'Bauchi', 'Bogoro', 'Dambam', 'Darazo',
            'Dass', 'Gamawa', 'Ganjuwa', 'Giade', 'Itas/Gadau',
            "Jama'are", 'Katagum', 'Kirfi', 'Misau', 'Ningi',
            'Shira', 'Tafawa Balewa', 'Toro', 'Warji', 'Zaki',
        ];
    }

    private function getWards(): array
    {
        return ['Ward 1', 'Ward 2', 'Ward 3', 'Ward 4', 'Ward 5'];
    }
}
