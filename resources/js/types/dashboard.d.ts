export interface DashboardStats {
  totalMembers: number;
  totalMembersGrowth: number;
  partyAgents: number;
  partyAgentsGrowth: number;
  coordinators: number;
  coordinatorsGrowth: number;
  stakeholders: number;
  stakeholdersGrowth: number;
  upcomingActivities: number;
  lgasCovered: number;
  totalLgas: number;
}

export interface MembershipByLga {
  lga: string;
  count: number;
}

export interface CampaignActivity {
  name: string;
  percentage: number;
  color: string;
}

export interface UpcomingActivity {
  date: string;
  month: string;
  day: number;
  title: string;
  location: string;
  time: string;
  isAllDay?: boolean;
}

export interface ElectionStrategyActivity {
  id: number;
  icon: string;
  title: string;
  description: string;
  status: 'Ongoing' | 'Planned' | 'Completed';
}

export interface LgaSupportData {
  lga: string;
  supportLevel: 'high' | 'medium' | 'low';
  coordinates?: [number, number];
}

export interface GovernorshipAspirant {
  name: string;
  title: string;
  state: string;
  vision: string;
  mission: string;
  imageUrl: string;
  overallProgress: number;
  totalSupporters: number;
  supportersGrowthThisWeek: number;
  campaignTeamMembers: number;
}

export interface AgentDeployment {
  deployed: number;
  deployedPct: number;
  unassigned: number;
  unassignedPct: number;
  awaitingTraining: number;
  awaitingTrainingPct: number;
  total: number;
}

export interface FinancialSummary {
  totalDonations: number;
  donationsGrowth: number;
  totalExpenditures: number;
  expendituresGrowth: number;
  balance: number;
  balanceGrowth: number;
}

export interface Announcement {
  id: number;
  title: string;
  date: string;
}

export interface RecentSupporter {
  id: number;
  name: string;
  lga: string;
  amount: number;
  imageUrl?: string;
}

export interface QuickAction {
  id: string;
  label: string;
  icon: string;
  color: string;
  route: string;
}

export interface NavItem {
  label: string;
  route?: string;
  icon?: string;
  children?: NavItem[];
}

export interface NavGroup {
  group: string;
  items: NavItem[];
}

export interface DashboardPageProps {
  stats: DashboardStats;
  membershipByLga: MembershipByLga[];
  campaignActivities: CampaignActivity[];
  upcomingActivities: UpcomingActivity[];
  electionStrategyActivities: ElectionStrategyActivity[];
  lgaSupportData: LgaSupportData[];
  aspirant: GovernorshipAspirant;
  agentDeployment: AgentDeployment;
  financialSummary: FinancialSummary;
  announcements: Announcement[];
  recentSupporters: RecentSupporter[];
  lgas: string[];
  wards: string[];
  selectedLga: string;
  selectedWard: string;
}
