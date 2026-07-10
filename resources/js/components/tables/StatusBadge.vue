<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  status: string
}
const props = defineProps<Props>()

const map: Record<string, { label: string; dot: string; text: string; bg: string }> = {
  active: { label: 'Active', dot: 'bg-green-600', text: 'text-green-700', bg: 'bg-green-50' },
  completed: { label: 'Completed', dot: 'bg-green-600', text: 'text-green-700', bg: 'bg-green-50' },
  pending: { label: 'Pending', dot: 'bg-amber-500', text: 'text-amber-700', bg: 'bg-amber-50' },
  not_started: { label: 'Not started', dot: 'bg-gray-400', text: 'text-gray-600', bg: 'bg-gray-50' },
  inactive: { label: 'Inactive', dot: 'bg-gray-400', text: 'text-gray-600', bg: 'bg-gray-50' },
  suspended: { label: 'Suspended', dot: 'bg-red-500', text: 'text-red-700', bg: 'bg-red-50' },
}

const style = computed(
  () =>
    map[props.status] ?? { label: props.status, dot: 'bg-gray-400', text: 'text-gray-600', bg: 'bg-gray-50' },
)
</script>

<template>
  <span
    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold"
    :class="[style.bg, style.text]"
  >
    <span class="h-1.5 w-1.5 rounded-full" :class="style.dot" />
    {{ style.label }}
  </span>
</template>