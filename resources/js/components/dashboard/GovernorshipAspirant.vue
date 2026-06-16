<script setup lang="ts">
import { Eye, Target } from 'lucide-vue-next'

const props = defineProps<{
  aspirant: {
    name: string
    title: string
    state: string
    image?: string
    vision?: string
    mission?: string
    campaignProgress?: number
    totalSupporters?: number
    supportersGrowth?: number
    campaignTeamMembers?: number
  }
}>()

// ✅ safe fallback helpers
const format = (val: number | undefined) =>
  (val ?? 0).toLocaleString()

const percent = (val: number | undefined) =>
  Math.min(Math.max(val ?? 0, 0), 100)
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 h-full flex flex-col gap-3 overflow-hidden">

    <!-- Header -->
    <h3 class="text-[10px] sm:text-xs font-black uppercase tracking-wider text-gray-800">
      Governorship Aspirant
    </h3>

    <!-- Profile -->
    <div class="flex items-center gap-3 min-w-0">
      <img
        :src="aspirant.image || '/default-avatar.png'"
        :alt="aspirant.name"
        class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl object-cover flex-shrink-0 border border-green-100"
      />

      <div class="min-w-0">
        <p class="text-xs sm:text-sm font-black text-gray-900 truncate">
          {{ aspirant.name }}
        </p>
        <p class="text-[10px] text-gray-500 font-medium truncate">
          {{ aspirant.title }}
        </p>
        <p class="text-[10px] text-gray-400 truncate">
          {{ aspirant.state }}
        </p>
      </div>
    </div>

    <!-- Vision & Mission -->
    <div class="space-y-2">
      <div class="flex items-start gap-2">
        <Eye class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5" />
        <div class="min-w-0">
          <p class="text-[9px] font-bold text-green-700 uppercase tracking-wider">Vision</p>
          <p class="text-[10px] text-gray-600 leading-snug line-clamp-2">
            {{ aspirant.vision || '—' }}
          </p>
        </div>
      </div>

      <div class="flex items-start gap-2">
        <Target class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5" />
        <div class="min-w-0">
          <p class="text-[9px] font-bold text-green-700 uppercase tracking-wider">Mission</p>
          <p class="text-[10px] text-gray-600 leading-snug line-clamp-2">
            {{ aspirant.mission || '—' }}
          </p>
        </div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="flex gap-2">
      <button class="flex-1 bg-green-700 hover:bg-green-800 text-white text-[10px] font-bold py-1.5 rounded-lg">
        Profile
      </button>
      <button class="flex-1 border border-gray-200 hover:bg-gray-50 text-gray-600 text-[10px] font-bold py-1.5 rounded-lg">
        Plan
      </button>
    </div>

    <!-- Progress -->
    <div>
      <div class="flex justify-between items-center mb-1">
        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-wider">
          Campaign Progress
        </p>
        <p class="text-[10px] font-black text-gray-900">
          {{ percent(aspirant.campaignProgress) }}%
        </p>
      </div>

      <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
        <div
          class="bg-green-600 h-1.5 rounded-full transition-all duration-500"
          :style="{ width: percent(aspirant.campaignProgress) + '%' }"
        />
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 gap-2">

      <div class="bg-gray-50 rounded-lg p-2 min-w-0">
        <p class="text-[9px] font-bold text-gray-400 uppercase">Supporters</p>
        <p class="text-sm font-black text-gray-900">
          {{ format(aspirant.totalSupporters) }}
        </p>
        <p class="text-[9px] text-green-600 font-semibold truncate">
          +{{ format(aspirant.supportersGrowth) }} this week
        </p>
      </div>

      <div class="bg-gray-50 rounded-lg p-2 min-w-0">
        <p class="text-[9px] font-bold text-gray-400 uppercase">Team</p>
        <p class="text-sm font-black text-gray-900">
          {{ format(aspirant.campaignTeamMembers) }}
        </p>
        <p class="text-[9px] text-gray-400 font-semibold">
          Active Members
        </p>
      </div>

    </div>

  </div>
</template>