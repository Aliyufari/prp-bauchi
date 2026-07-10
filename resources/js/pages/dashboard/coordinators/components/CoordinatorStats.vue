<script setup lang="ts">
import StatCard from '@/components/dashboard/StatCard.vue'
import type { CoordinatorStatistics } from '@/types/coordinator'

interface Props {
  statistics: CoordinatorStatistics
}
defineProps<Props>()
</script>

<template>
  <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
    <StatCard
      :value="statistics.total"
      label="Total Coordinators"
      icon="Users"
      icon-bg="bg-green-100"
      icon-color="text-green-700"
    />
    <StatCard
      :value="statistics.active"
      label="Active"
      icon="UserCheck"
      icon-bg="bg-blue-100"
      icon-color="text-blue-700"
    />
    <StatCard
      :value="statistics.state_level"
      label="State-level"
      icon="Building2"
      icon-bg="bg-purple-100"
      icon-color="text-purple-700"
    />
    <StatCard
      :value="statistics.assigned"
      label="Assigned to LGA"
      icon="MapPin"
      icon-bg="bg-amber-100"
      icon-color="text-amber-700"
    />
  </div>
</template>