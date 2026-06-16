<script setup lang="ts">
import { computed } from 'vue'
import VChart from 'vue-echarts'
import * as echarts from 'echarts'

const props = defineProps<{
  deployment: {
    total: number
    deployed: number
    deployedPct: number
    unassigned: number
    unassignedPct: number
    awaitingTraining: number
    awaitingTrainingPct: number
  }
}>()

const option = computed(() => ({
  tooltip: {
    trigger: 'item'
  },
  series: [
    {
      type: 'pie',
      radius: ['55%', '75%'],
      data: [
        { value: props.deployedPct, name: 'Deployed' },
        { value: props.unassignedPct, name: 'Unassigned' },
        { value: props.awaitingTrainingPct, name: 'Awaiting Training' },
      ],
      label: { show: false },
      color: ['#15803d', '#f59e0b', '#ef4444'],
    }
  ]
}))
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">

    <!-- Header -->
    <div>
      <h3 class="text-xs font-black uppercase tracking-wider text-gray-800">
        Agent Deployment Status
      </h3>
      <p class="text-[10px] text-gray-400 mt-0.5 font-medium">
        Current field agent allocation
      </p>
    </div>

    <!-- Chart -->
    <div class="relative mx-auto w-[120px] h-[120px]">
      <VChart class="w-full h-full" :option="option" autoresize />

      <!-- Center Text -->
      <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
        <p class="text-sm font-black text-gray-900">
          {{ deployment.total.toLocaleString() }}
        </p>
        <p class="text-[9px] text-gray-400 font-medium">
          Total Agents
        </p>
      </div>
    </div>

    <!-- Breakdown -->
    <ul class="space-y-1.5">

      <li class="flex items-center justify-between">
        <div class="flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-green-700" />
          <span class="text-[10px] text-gray-600">Deployed</span>
        </div>
        <span class="text-[10px] font-bold">
          {{ deployment.deployed.toLocaleString() }} ({{ deployment.deployedPct }}%)
        </span>
      </li>

      <li class="flex items-center justify-between">
        <div class="flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-amber-400" />
          <span class="text-[10px] text-gray-600">Unassigned</span>
        </div>
        <span class="text-[10px] font-bold">
          {{ deployment.unassigned.toLocaleString() }} ({{ deployment.unassignedPct }}%)
        </span>
      </li>

      <li class="flex items-center justify-between">
        <div class="flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-red-500" />
          <span class="text-[10px] text-gray-600">Awaiting Training</span>
        </div>
        <span class="text-[10px] font-bold">
          {{ deployment.awaitingTraining.toLocaleString() }} ({{ deployment.awaitingTrainingPct }}%)
        </span>
      </li>

    </ul>

    <!-- Button -->
    <button class="w-full text-[10px] font-bold text-green-700 hover:text-green-800 py-1.5 border border-green-100 rounded-lg">
      View Full Report →
    </button>

  </div>
</template>