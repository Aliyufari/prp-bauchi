<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3'
import SlideOver from '@/components/ui/SlideOver.vue'
import MemberForm from './components/MemberForm.vue'
import type { LocationOption } from '@/types/member'

interface Props {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  pus: LocationOption[]
}
defineProps<Props>()

const form = useForm({
  first_name: '',
  middle_name: '' as string | null,
  last_name: '',
  email: '',
  password: '',
  phone: '' as string | null,

  gender: null as string | null,
  occupation: '' as string | null,
  education_status: '' as string | null,
  applied_id: '' as string | null,

  state_id: null as number | string | null,
  zone_id: null as number | string | null,
  lga_id: null as number | string | null,
  ward_id: null as number | string | null,
  pu_id: null as number | string | null,

  mentor_name: '' as string | null,
  mentor_status: false,
  training_status: false,
})

function submit() {
  form.post(route('members.store'), {
    onSuccess: close,
  })
}

function close() {
  router.visit(route('members.index'), { preserveScroll: true })
}
</script>

<template>
  <Head title="Add Member" />
  <SlideOver
    title="Add Member"
    description="Register a new member to the party database."
    size="lg"
    side="right"
    @close="close"
  >
    <MemberForm
      :form="form"
      submit-label="Create member"
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
