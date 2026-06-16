<script setup lang="ts">
defineProps<{
  announcements: { title: string; date: string }[]
}>()
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">
    <div>
      <h3 class="text-xs font-black uppercase tracking-wider text-gray-800">Recent Announcements</h3>
      <p class="text-[10px] text-gray-400 mt-0.5 font-medium">Latest party communications</p>
    </div>

    <ul class="flex-1 space-y-2">
      <li
        v-for="a in announcements"
        :key="a.title"
        class="flex items-start gap-2 p-2 rounded-lg hover:bg-gray-50 transition-colors cursor-default"
      >
        <span class="w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0 mt-1.5" />
        <div class="min-w-0">
          <p class="text-[10px] font-semibold text-gray-800 leading-snug">{{ a.title }}</p>
          <p class="text-[9px] text-gray-400 mt-0.5">{{ a.date }}</p>
        </div>
      </li>
    </ul>

    <button class="w-full text-[10px] font-bold text-green-700 hover:text-green-800 text-center py-1.5 border border-green-100 hover:border-green-200 rounded-lg transition-colors">
      View All Announcements →
    </button>
  </div>
</template>