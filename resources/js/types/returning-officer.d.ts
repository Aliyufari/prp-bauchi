import type { LocationOption } from '@/types/member'

export interface ReturningOfficer {
  id: string
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  avatar_url: string | null
  status: 'active' | 'inactive'

  officer_no: string | null
  phone: string | null
  gender: string | null
  occupation: string | null
  education_status: string | null

  institution: string | null
  posting_location: string | null

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

export interface ReturningOfficerStatistics {
  total: number
  active: number
  assigned: number
  institutions: number
}

export interface ReturningOfficerFilterOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  statuses: { value: string; label: string }[]
}