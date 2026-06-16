<template>
  <div class="bg-white rounded-lg border border-gray-200 p-5">
    <div class="flex items-center justify-between mb-4">
      <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">
        Election Victory Strategy Activities
      </h3>
    </div>

    <div class="space-y-3">
      <div
        v-for="activity in activities"
        :key="activity.id"
        class="flex items-start gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors"
      >
        <!-- Icon -->
        <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
          <component :is="getIcon(activity.icon)" class="w-4 h-4 text-green-700" />
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
          <p class="text-sm font-semibold text-gray-800 leading-tight">{{ activity.title }}</p>
          <p class="text-xs text-gray-500 mt-0.5 truncate">{{ activity.description }}</p>
        </div>

        <!-- Status badge -->
        <span
          :class="[
            'flex-shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-full',
            statusClasses[activity.status],
          ]"
        >
          {{ activity.status }}
        </span>
      </div>
    </div>

    <button class="mt-4 w-full text-center text-xs font-semibold text-green-700 hover:text-green-800 py-2 border border-green-200 rounded-md hover:bg-green-50 transition-colors">
      View All Activities →
    </button>
  </div>
</template>

<script setup lang="ts">
import {
  Megaphone, DoorOpen, BookOpen, Baby, Handshake, Star, Eye, Database
} from 'lucide-vue-next'
import type { ElectionStrategyActivity } from '@/types/dashboard'

defineProps<{ activities: ElectionStrategyActivity[] }>()

const iconMap: Record<string, any> = {
  Megaphone, DoorOpen, BookOpen, Baby, Handshake, Star, Eye, Database,
}

function getIcon(name: string) {
  return iconMap[name] ?? Megaphone
}

const statusClasses: Record<string, string> = {
  Ongoing: 'bg-green-100 text-green-700',
  Planned: 'bg-yellow-100 text-yellow-700',
  Completed: 'bg-blue-100 text-blue-700',
}
</script>
