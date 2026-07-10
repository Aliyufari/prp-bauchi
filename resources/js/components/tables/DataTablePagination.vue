<script setup lang="ts">
import { computed } from 'vue'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

interface Props {
  currentPage: number
  lastPage: number
  from: number | null
  to: number | null
  total: number
  perPage: number
}
const props = defineProps<Props>()
const emit = defineEmits<{
  'update:currentPage': [page: number]
  'update:perPage': [perPage: number]
}>()

const pages = computed(() => {
  const range: (number | '...')[] = []
  const { currentPage, lastPage } = props
  const window = 1

  for (let p = 1; p <= lastPage; p++) {
    if (p === 1 || p === lastPage || Math.abs(p - currentPage) <= window) {
      range.push(p)
    } else if (range[range.length - 1] !== '...') {
      range.push('...')
    }
  }
  return range
})
</script>

<template>
  <div class="flex flex-col gap-3 border-t border-gray-100 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-2 text-xs text-gray-500">
      <span>
        Showing <span class="font-semibold text-gray-700">{{ from ?? 0 }}</span>–<span class="font-semibold text-gray-700">{{ to ?? 0 }}</span>
        of <span class="font-semibold text-gray-700">{{ total }}</span>
      </span>
      <select
        :value="perPage"
        @change="emit('update:perPage', Number(($event.target as HTMLSelectElement).value))"
        class="rounded-lg border border-gray-200 px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-green-500"
      >
        <option v-for="n in [10, 25, 50, 100]" :key="n" :value="n">{{ n }} / page</option>
      </select>
    </div>

    <div class="flex items-center gap-1 self-end">
      <button
        type="button"
        :disabled="currentPage <= 1"
        @click="emit('update:currentPage', currentPage - 1)"
        class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 disabled:cursor-not-allowed disabled:opacity-40"
      >
        <ChevronLeft class="h-4 w-4" />
      </button>

      <template v-for="(p, i) in pages" :key="i">
        <span v-if="p === '...'" class="px-1.5 text-xs text-gray-300">…</span>
        <button
          v-else
          type="button"
          @click="emit('update:currentPage', p)"
          class="h-7 w-7 rounded-lg text-xs font-semibold transition"
          :class="p === currentPage ? 'bg-green-700 text-white' : 'text-gray-600 hover:bg-gray-100'"
        >
          {{ p }}
        </button>
      </template>

      <button
        type="button"
        :disabled="currentPage >= lastPage"
        @click="emit('update:currentPage', currentPage + 1)"
        class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 disabled:cursor-not-allowed disabled:opacity-40"
      >
        <ChevronRight class="h-4 w-4" />
      </button>
    </div>
  </div>
</template>