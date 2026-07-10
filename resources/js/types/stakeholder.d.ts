import type { LocationOption } from '@/types/member'

export interface Stakeholder {
  id: string
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  avatar_url: string | null
  status: 'active' | 'inactive'

  stakeholder_no: string | null
  phone: string | null
  gender: string | null
  occupation: string | null
  education_status: string | null

  stakeholder_type: string | null
  stakeholder_type_label: string | null
  organization: string | null
  designation: string | null

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

export interface StakeholderStatistics {
  total: number
  active: number
  traditional_rulers: number
  organizations: number
}

export interface StakeholderTypeOption {
  value: string
  label: string
}

export interface StakeholderFilterOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  statuses: { value: string; label: string }[]
  types: StakeholderTypeOption[]
}