export interface Aspirant {
  id: string
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  phone: string | null
  status: 'active' | 'inactive'

  office: string | null
  office_label: string | null
  title: string | null
  vision: string | null
  mission: string | null
  image_url: string | null

  overall_progress: number
  total_supporters: number
  supporters_growth_this_week: number
  campaign_team_members: number

  constituency_id: string | null
  constituency: string | null
  state: string | null

  created_at: string
}

export interface AspirantStatistics {
  total: number
  active: number
  governor: number
  constituencies: number
}

export interface AspirantOfficeOption {
  value: string
  label: string
}

export interface AspirantFilterOptions {
  offices: AspirantOfficeOption[]
  statuses: { value: string; label: string }[]
}

export interface ConstituencyOption {
  id: string
  name: string
}