<script setup lang="ts">
import StatCard from '@/components/dashboard/StatCard.vue'
import type { MemberStatistics } from '@/types/member'

interface Props {
  statistics: MemberStatistics
}
defineProps<Props>()
</script>

<template>
  <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
    <StatCard
      :value="statistics.total"
      label="Total Members"
      icon="Users"
      icon-bg="bg-green-100"
      icon-color="text-green-700"
    />
    <StatCard
      :value="statistics.active"
      label="Active Members"
      icon="UserCheck"
      icon-bg="bg-blue-100"
      icon-color="text-blue-700"
    />
    <StatCard
      :value="statistics.trained"
      label="Trained"
      icon="GraduationCap"
      icon-bg="bg-purple-100"
      icon-color="text-purple-700"
    />
    <StatCard
      :value="statistics.mentored"
      label="Mentored"
      icon="Handshake"
      icon-bg="bg-amber-100"
      icon-color="text-amber-700"
    />
  </div>
</template>