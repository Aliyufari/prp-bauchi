<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import SlideOver from '@/components/ui/SlideOver.vue'
import MemberForm from './components/MemberForm.vue'
import { emptyMemberFormValues, memberToFormValues } from '@/composables/members/useMember'
import type { Member, LocationOption } from '@/types/member'

interface FormOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  pus: LocationOption[]
}

interface Props {
  member: Member | null
  formOptions: FormOptions
}
const props = defineProps<Props>()

const emit = defineEmits<{
  close: []
}>()

const form = useForm(emptyMemberFormValues())

// Re-seed whenever a new member is opened for editing
watch(
  () => props.member,
  (member) => {
    if (!member) return
    form.clearErrors()
    const values = memberToFormValues(member)
    form.defaults(values)
    form.reset()
    Object.assign(form, values)
  },
  { immediate: true },
)

function submit() {
  if (!props.member) return
  form.patch(route('members.update', props.member.id), {
    preserveScroll: true,
    onSuccess: () => emit('close'),
  })
}

function cancel() {
  form.clearErrors()
  emit('close')
}
</script>

<template>
  <SlideOver
    :open="member !== null"
    title="Edit Member"
    :description="member ? `Update details for ${member.first_name} ${member.last_name}.` : ''"
    size="lg"
    side="right"
    @close="cancel"
  >
    <MemberForm
      v-if="member"
      :form="form"
      submit-label="Save changes"
      :password-optional="true"
      :states="formOptions.states"
      :zones="formOptions.zones"
      :lgas="formOptions.lgas"
      :wards="formOptions.wards"
      :pus="formOptions.pus"
      @submit="submit"
      @cancel="cancel"
    />
  </SlideOver>
</template>