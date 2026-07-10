<script setup lang="ts">
import { SearchX } from 'lucide-vue-next'

interface Props {
  title?: string
  description?: string
}
withDefaults(defineProps<Props>(), {
  title: 'No records found',
  description: 'Try adjusting your search or filters.',
})
</script>

<template>
  <div class="flex flex-col items-center justify-center gap-3 py-16 text-center">
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
      <SearchX class="h-5 w-5 text-gray-400" />
    </div>
    <div>
      <p class="text-sm font-semibold text-gray-900">{{ title }}</p>
      <p class="mt-1 text-xs text-gray-500">{{ description }}</p>
    </div>
    <slot name="action" />
  </div>
</template>