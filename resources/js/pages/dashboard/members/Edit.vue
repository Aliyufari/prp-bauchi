<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3'
import SlideOver from '@/components/ui/SlideOver.vue'
import MemberForm from './components/MemberForm.vue'
import type { Member, LocationOption } from '@/types/member'

interface Props {
  member: Member
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  pus: LocationOption[]
}
const props = defineProps<Props>()

const form = useForm({
  first_name: props.member.first_name,
  middle_name: props.member.middle_name,
  last_name: props.member.last_name,
  email: props.member.email,
  password: '',
  phone: props.member.phone,

  gender: props.member.gender,
  occupation: props.member.occupation,
  education_status: props.member.education_status,
  applied_id: props.member.member_no,

  state_id: props.member.state_id,
  zone_id: props.member.zone_id,
  lga_id: props.member.lga_id,
  ward_id: props.member.ward_id,
  pu_id: props.member.pu_id,

  mentor_name: props.member.mentor,
  mentor_status: props.member.mentor_status,
  training_status: props.member.training_status === 'completed',
})

function submit() {
  form.patch(route('members.update', props.member.id), {
    onSuccess: close,
  })
}

function close() {
  router.visit(route('members.index'), { preserveScroll: true })
}
</script>

<template>
  <Head title="Edit Member" />
  <SlideOver
    title="Edit Member"
    :description="`Update details for ${member.first_name} ${member.last_name}.`"
    size="lg"
    side="right"
    @close="close"
  >
    <MemberForm
      :form="form"
      submit-label="Save changes"
      password-optional
      :states="states"
      :zones="zones"
      :lgas="lgas"
      :wards="wards"
      :pus="pus"
      @submit="submit"
      @cancel="close"
    />
  </SlideOver>
</template>
