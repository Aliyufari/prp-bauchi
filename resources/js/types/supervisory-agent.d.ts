import type { LocationOption } from '@/types/member'

export interface SupervisoryAgent {
  id: string
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  avatar_url: string | null
  status: 'active' | 'inactive'

  agent_no: string | null
  phone: string | null
  gender: string | null
  occupation: string | null
  education_status: string | null

  supervisor_type: string | null
  supervisor_type_label: string | null
  agents_supervised: number

  state_id: string | null
  zone_id: string | null
  lga_id: string | null
  ward_id: string | null
  pu_id: string | null

  state: string | null
  zone: string | null
  lga: string | null
  ward: string | null
  pu: string | null

  created_at: string
}

export interface SupervisoryAgentStatistics {
  total: number
  active: number
  total_agents_supervised: number
  unassigned: number
}

export interface SupervisoryAgentTypeOption {
  value: string
  label: string
}

export interface SupervisoryAgentFilterOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  statuses: { value: string; label: string }[]
  types: SupervisoryAgentTypeOption[]
}