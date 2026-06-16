<script setup lang="ts">
import { computed, ref } from 'vue'
import VChart from 'vue-echarts'

const props = defineProps<{
  data: { lga: string; count: number }[]
}>()

const period = ref('This Month')
const periods = ['This Week', 'This Month', 'This Quarter', 'This Year']

const option = computed(() => ({
  tooltip: {
    trigger: 'axis'
  },
  grid: {
    left: 10,
    right: 10,
    bottom: 60,
    top: 20
  },
  xAxis: {
    type: 'category',
    data: props.data.map(d => d.lga),
    axisLabel: {
      rotate: 45,
      fontSize: 8,
      color: '#9ca3af'
    },
    axisLine: { show: false },
    axisTick: { show: false }
  },
  yAxis: {
    type: 'value',
    axisLabel: {
      fontSize: 8,
      color: '#9ca3af',
      formatter: (v: number) => (v >= 1000 ? `${v / 1000}k` : v)
    },
    splitLine: {
      lineStyle: { color: '#f0f0f0' }
    }
  },
  series: [
    {
      type: 'bar',
      data: props.data.map(d => d.count),
      itemStyle: {
        color: '#15803d',
        borderRadius: [4, 4, 0, 0]
      },
      barMaxWidth: 20
    }
  ]
}))
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 h-full flex flex-col">

    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
      <div>
        <h3 class="text-xs font-black uppercase tracking-wider text-gray-800">
          Membership by LGA
        </h3>
        <p class="text-[10px] text-gray-400 mt-0.5 font-medium">
          Member distribution across local governments
        </p>
      </div>

      <select
        v-model="period"
        class="text-[10px] font-semibold border border-gray-200 rounded-lg px-2 py-1.5 bg-white text-gray-600"
      >
        <option v-for="p in periods" :key="p">{{ p }}</option>
      </select>
    </div>

    <!-- Chart -->
    <div class="flex-1 min-h-0 h-[220px]">
      <VChart class="w-full h-full" :option="option" autoresize />
    </div>

  </div>
</template>