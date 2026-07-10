export interface LocationOption {
  id: string
  name: string
}

export interface Member {
  id: string
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  avatar_url: string | null
  status: 'active' | 'inactive'
  member_no: string | null
  phone: string | null
  gender: string | null
  occupation: string | null
  education_status: string | null
  training_status: boolean
  training_status_label: 'completed' | 'pending'
  mentor: string | null
  mentor_name: string | null
  mentor_status: boolean
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

export interface MemberStatistics {
  total: number
  active: number
  trained: number
  mentored: number
}

export interface MemberFilterOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  statuses: { value: string; label: string }[]
}