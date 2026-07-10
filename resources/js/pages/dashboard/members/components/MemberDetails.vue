<script setup lang="ts">
import { computed } from 'vue'
import { Mail, Phone, MapPin, GraduationCap, UserCheck } from 'lucide-vue-next'
import StatusBadge from '@/components/tables/StatusBadge.vue'
import type { Member } from '@/types/member'

interface Props {
  member: Member
}
const props = defineProps<Props>()

const fullName = computed(() =>
  [props.member.first_name, props.member.middle_name, props.member.last_name].filter(Boolean).join(' '),
)
const initials = computed(
  () => `${props.member.first_name?.[0] ?? ''}${props.member.last_name?.[0] ?? ''}`.toUpperCase(),
)
const joinedAt = computed(() =>
  new Date(props.member.created_at).toLocaleDateString(undefined, {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }),
)
</script>

<template>
  <div class="space-y-6">
    <!-- Identity -->
    <div class="flex items-center gap-4">
      <img
        v-if="member.avatar_url"
        :src="member.avatar_url"
        :alt="fullName"
        class="h-16 w-16 rounded-2xl object-cover"
      />
      <div
        v-else
        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-green-100 text-lg font-bold text-green-700"
      >
        {{ initials }}
      </div>
      <div>
        <p class="text-base font-bold text-gray-900">{{ fullName }}</p>
        <p class="text-xs text-gray-500">{{ member.member_no }}</p>
        <div class="mt-1.5">
          <StatusBadge :status="member.status" />
        </div>
      </div>
    </div>

    <!-- Contact -->
    <div class="grid grid-cols-1 gap-3 rounded-xl border border-gray-100 p-4 sm:grid-cols-2">
      <div class="flex items-start gap-2.5">
        <Mail class="mt-0.5 h-4 w-4 shrink-0 text-gray-400" />
        <div>
          <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">Email</p>
          <p class="text-sm text-gray-700">{{ member.email }}</p>
        </div>
      </div>
      <div class="flex items-start gap-2.5">
        <Phone class="mt-0.5 h-4 w-4 shrink-0 text-gray-400" />
        <div>
          <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">Phone</p>
          <p class="text-sm text-gray-700">{{ member.phone ?? '—' }}</p>
        </div>
      </div>
      <div class="flex items-start gap-2.5 sm:col-span-2">
        <MapPin class="mt-0.5 h-4 w-4 shrink-0 text-gray-400" />
        <div>
          <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">Location</p>
          <p class="text-sm text-gray-700">
            {{ member.ward }} Ward, {{ member.lga }} LGA, {{ member.state }} State
          </p>
        </div>
      </div>
    </div>

    <!-- Mentorship & training -->
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
      <div class="flex items-start gap-2.5 rounded-xl border border-gray-100 p-4">
        <UserCheck class="mt-0.5 h-4 w-4 shrink-0 text-gray-400" />
        <div>
          <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">Mentor</p>
          <p class="text-sm text-gray-700">{{ member.mentor ?? 'Not assigned' }}</p>
        </div>
      </div>
      <div class="flex items-start gap-2.5 rounded-xl border border-gray-100 p-4">
        <GraduationCap class="mt-0.5 h-4 w-4 shrink-0 text-gray-400" />
        <div>
          <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">Training</p>
          <StatusBadge :status="member.training_status_label" />
        </div>
      </div>
    </div>

    <p class="text-xs text-gray-400">Joined {{ joinedAt }}</p>
  </div>
</template>