import type { Member } from '@/types/member'

export function emptyMemberFormValues() {
  return {
    first_name: '',
    middle_name: '' as string | null,
    last_name: '',
    email: '',
    password: '',
    phone: '' as string | null,
    gender: null as string | null,
    occupation: '' as string | null,
    education_status: '' as string | null,
    application_id: '' as string | null,
    state_id: null as number | string | null,
    zone_id: null as number | string | null,
    lga_id: null as number | string | null,
    ward_id: null as number | string | null,
    pu_id: null as number | string | null,
    mentor_name: '' as string | null,
    mentor_status: false,
    training_status: false,
  }
}

export function memberToFormValues(member: Member) {
  return {
    first_name: member.first_name,
    middle_name: member.middle_name,
    last_name: member.last_name,
    email: member.email,
    password: '',
    phone: member.phone,
    gender: member.gender,
    occupation: member.occupation,
    education_status: member.education_status,
    application_id: member.member_no,
    state_id: member.state_id,
    zone_id: member.zone_id,
    lga_id: member.lga_id,
    ward_id: member.ward_id,
    pu_id: member.pu_id,
    mentor_name: member.mentor,
    mentor_status: member.mentor_status,
    training_status: member.training_status,
  }
}