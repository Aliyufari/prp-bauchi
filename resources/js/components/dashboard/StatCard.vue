<script setup lang="ts">
import { computed } from 'vue'
import {
  Users, UserCheck, Briefcase, Handshake, Calendar, BarChart3, TrendingUp, TrendingDown
} from 'lucide-vue-next'

const iconMap: Record<string, any> = {
  Users, UserCheck, Briefcase, Handshake, Calendar, BarChart3,
}

const props = defineProps<{
  value: number
  label: string
  icon: string
  growth?: number
  subtitle?: string
  iconBg?: string
  iconColor?: string
}>()

const iconComponent = computed(() => iconMap[props.icon] ?? Users)
const formattedValue = computed(() => props.value.toLocaleString())
</script>

<template>
  <div
    class="relative rounded-xl overflow-hidden bg-white border border-gray-100
           hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200
           cursor-default shadow-sm w-full min-w-0
           flex flex-col gap-1 px-3 pt-2.5 pb-2 min-h-[90px]"
  >
    <!-- ROW 1: Growth badge right -->
    <div class="flex justify-end">
      <span
        v-if="growth !== undefined"
        :class="[
          'inline-flex items-center gap-0.5 text-[9px] font-bold px-1.5 py-0.5 rounded-full',
          growth >= 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600'
        ]"
      >
        <TrendingUp v-if="growth >= 0" class="w-2.5 h-2.5" />
        <TrendingDown v-else class="w-2.5 h-2.5" />
        {{ growth >= 0 ? '+' : '' }}{{ growth }}%
      </span>
    </div>

    <!-- ROW 2: Label -->
    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-500 leading-tight truncate">
      {{ label }}
    </p>

    <!-- ROW 3: Value + Icon -->
    <div class="flex items-end justify-between mt-auto">
      <div class="min-w-0">
        <p class="text-2xl font-black text-gray-900 leading-none truncate">
          {{ formattedValue }}
        </p>
        <p v-if="subtitle" class="text-[9px] text-gray-400 mt-0.5 truncate font-medium">
          {{ subtitle }}
        </p>
      </div>

      <component
        :is="iconComponent"
        :class="['w-6 h-6 flex-shrink-0 opacity-25 mb-0.5', iconColor]"
      />
    </div>
  </div>
</template>