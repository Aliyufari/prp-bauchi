<script setup lang="ts">
import StatCard from '@/components/dashboard/StatCard.vue'
import type { PartyAgentStatistics } from '@/types/party-agent'

interface Props {
  statistics: PartyAgentStatistics
}
defineProps<Props>()
</script>

<template>
  <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
    <StatCard
      :value="statistics.total"
      label="Total Agents"
      icon="Users"
      icon-bg="bg-green-100"
      icon-color="text-green-700"
    />
    <StatCard
      :value="statistics.active"
      label="Active Agents"
      icon="UserCheck"
      icon-bg="bg-blue-100"
      icon-color="text-blue-700"
    />
    <StatCard
      :value="statistics.deployed"
      label="Deployed"
      icon="MapPin"
      icon-bg="bg-purple-100"
      icon-color="text-purple-700"
    />
    <StatCard
      :value="statistics.unassigned"
      label="Unassigned"
      icon="AlertCircle"
      icon-bg="bg-amber-100"
      icon-color="text-amber-700"
    />
  </div>
</template>