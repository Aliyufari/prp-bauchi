<template>
  <div class="bg-white rounded-lg border border-gray-200 p-5">
    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide mb-4">
      Governorship Aspirant
    </h3>

    <!-- Profile -->
    <div class="flex gap-4 mb-4">
      <div class="w-20 h-24 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
        <img
          v-if="aspirant.imageUrl"
          :src="aspirant.imageUrl"
          :alt="aspirant.name"
          class="w-full h-full object-cover"
        />
        <div v-else class="w-full h-full bg-green-700 flex items-center justify-center">
          <User class="w-8 h-8 text-white" />
        </div>
      </div>
      <div class="min-w-0">
        <p class="font-extrabold text-gray-900 text-sm leading-snug">{{ aspirant.name }}</p>
        <p class="text-xs text-gray-500 mt-0.5">{{ aspirant.title }}</p>
        <p class="text-xs text-gray-500">{{ aspirant.state }}</p>

        <div class="mt-2 space-y-2">
          <div class="flex items-start gap-1.5">
            <Eye class="w-3.5 h-3.5 text-green-600 mt-0.5 flex-shrink-0" />
            <div>
              <span class="text-[10px] font-bold text-green-600">Vision:</span>
              <span class="text-[10px] text-gray-600"> {{ aspirant.vision }}</span>
            </div>
          </div>
          <div class="flex items-start gap-1.5">
            <Target class="w-3.5 h-3.5 text-red-500 mt-0.5 flex-shrink-0" />
            <div>
              <span class="text-[10px] font-bold text-red-500">Mission:</span>
              <span class="text-[10px] text-gray-600"> {{ aspirant.mission }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-2 mb-5">
      <button class="flex-1 bg-green-700 hover:bg-green-800 text-white text-xs font-semibold py-2 rounded-md transition-colors">
        Aspirant Profile
      </button>
      <button class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-600 text-xs font-semibold py-2 rounded-md transition-colors">
        View Campaign Plan
      </button>
    </div>

    <!-- Campaign Progress -->
    <div class="mb-5">
      <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">Campaign Progress</h4>
      <div class="flex items-center justify-between mb-1.5">
        <span class="text-xs text-gray-600">Overall Progress</span>
        <span class="text-xs font-bold text-gray-800">{{ aspirant.overallProgress }}%</span>
      </div>
      <div class="h-2.5 bg-gray-200 rounded-full overflow-hidden">
        <div
          class="h-full bg-green-600 rounded-full transition-all duration-1000"
          :style="{ width: aspirant.overallProgress + '%' }"
        />
      </div>
    </div>

    <!-- Supporters & Team -->
    <div class="grid grid-cols-2 gap-3 mb-5">
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="flex items-center gap-2 mb-1">
          <Users class="w-4 h-4 text-green-600" />
          <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">Total Supporters</span>
        </div>
        <p class="text-xl font-extrabold text-gray-800">{{ aspirant.totalSupporters.toLocaleString() }}</p>
        <p class="text-[10px] text-green-600 font-medium">
          +{{ aspirant.supportersGrowthThisWeek.toLocaleString() }} this week
        </p>
      </div>
      <div class="bg-gray-50 rounded-lg p-3">
        <div class="flex items-center gap-2 mb-1">
          <UserCheck class="w-4 h-4 text-purple-600" />
          <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">Campaign Team</span>
        </div>
        <p class="text-xl font-extrabold text-gray-800">{{ aspirant.campaignTeamMembers }}</p>
        <p class="text-[10px] text-gray-500">Active Members</p>
      </div>
    </div>

    <!-- Quick Actions -->
    <div>
      <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">Quick Actions</h4>
      <div class="grid grid-cols-3 gap-2">
        <button
          v-for="action in quickActions"
          :key="action.id"
          :class="['flex flex-col items-center gap-1.5 p-2 rounded-lg border transition-all hover:shadow-sm', action.bg, action.border]"
        >
          <div :class="['w-7 h-7 rounded-full flex items-center justify-center', action.iconBg]">
            <component :is="action.iconComponent" class="w-3.5 h-3.5 text-white" />
          </div>
          <span class="text-[10px] text-gray-600 font-medium text-center leading-tight">{{ action.label }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Users, UserCheck, User, Eye, Target, UserPlus, Bot, CalendarPlus, HandCoins, MessageSquare, FileBarChart } from 'lucide-vue-next'
import type { GovernorshipAspirant } from '@/types/dashboard'

defineProps<{ aspirant: GovernorshipAspirant }>()

const quickActions = [
  { id: 'add-member', label: 'Add New Member', iconComponent: UserPlus, bg: 'bg-green-50', border: 'border-green-100', iconBg: 'bg-green-600' },
  { id: 'register-agent', label: 'Register New Agent', iconComponent: Bot, bg: 'bg-blue-50', border: 'border-blue-100', iconBg: 'bg-blue-600' },
  { id: 'schedule', label: 'Schedule Activity', iconComponent: CalendarPlus, bg: 'bg-yellow-50', border: 'border-yellow-100', iconBg: 'bg-yellow-600' },
  { id: 'donation', label: 'Add Donation', iconComponent: HandCoins, bg: 'bg-purple-50', border: 'border-purple-100', iconBg: 'bg-purple-600' },
  { id: 'sms', label: 'Send SMS', iconComponent: MessageSquare, bg: 'bg-gray-50', border: 'border-gray-100', iconBg: 'bg-gray-500' },
  { id: 'report', label: 'Generate Report', iconComponent: FileBarChart, bg: 'bg-red-50', border: 'border-red-100', iconBg: 'bg-red-500' },
]
</script>
