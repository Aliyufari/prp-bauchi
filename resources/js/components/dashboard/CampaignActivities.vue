<script setup lang="ts">
import { computed } from 'vue'
import VChart from 'vue-echarts'

const props = defineProps<{
  activities: { name: string; percentage: number; color: string }[]
  totalActivities: number
}>()

const option = computed(() => ({
  tooltip: {
    trigger: 'item'
  },
  series: [
    {
      type: 'pie',
      radius: ['45%', '68%'],
      data: props.activities.map(a => ({
        value: a.percentage,
        name: a.name,
        itemStyle: { color: a.color }
      })),
      label: { show: false }
    }
  ]
}))
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 h-full flex flex-col">

    <!-- Header -->
    <div class="mb-3">
      <h3 class="text-xs font-black uppercase tracking-wider text-gray-800">
        Campaign Activities Overview
      </h3>
      <p class="text-[10px] text-gray-400 mt-0.5 font-medium">
        Breakdown of ongoing campaign efforts
      </p>
    </div>

    <!-- Chart + Legend -->
    <div class="flex flex-col sm:flex-row items-center gap-4 flex-1">

      <!-- Chart -->
      <div class="relative w-[150px] h-[150px]">
        <VChart class="w-full h-full" :option="option" autoresize />

        <!-- Center -->
        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
          <p class="text-lg font-black text-gray-900">
            {{ totalActivities }}
          </p>
          <p class="text-[9px] text-gray-400 uppercase">Activities</p>
        </div>
      </div>

      <!-- Legend -->
      <ul class="flex-1 space-y-1.5 min-w-0">
        <li
          v-for="a in activities"
          :key="a.name"
          class="flex items-center justify-between"
        >
          <div class="flex items-center gap-2 min-w-0">
            <span class="w-2 h-2 rounded-full flex-shrink-0" :style="{ background: a.color }" />
            <span class="text-[10px] text-gray-600 truncate">{{ a.name }}</span>
          </div>
          <span class="text-[10px] font-bold">{{ a.percentage }}%</span>
        </li>
      </ul>

    </div>
  </div>
</template>