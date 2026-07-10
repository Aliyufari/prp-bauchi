<script setup lang="ts">
import { Search, Download, Upload, RefreshCw } from 'lucide-vue-next'

interface Props {
  modelValue: string
  placeholder?: string
  showExport?: boolean
  showImport?: boolean
  showRefresh?: boolean
}
withDefaults(defineProps<Props>(), {
  placeholder: 'Search...',
  showExport: false,
  showImport: false,
  showRefresh: false,
})

const emit = defineEmits<{
  'update:modelValue': [value: string]
  refresh: []
  export: []
  import: []
}>()
</script>

<template>
  <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
    <div class="relative w-full lg:max-w-xs">
      <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
      <input
        :value="modelValue"
        @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
        type="text"
        :placeholder="placeholder"
        class="w-full rounded-xl border border-gray-200 bg-white py-2 pl-9 pr-3 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
      />
    </div>

    <div class="flex flex-wrap items-center gap-2">
      <slot name="filters" />

      <button
        v-if="showRefresh"
        type="button"
        @click="emit('refresh')"
        class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50"
      >
        <RefreshCw class="h-3.5 w-3.5" />
        Refresh
      </button>

      <button
        v-if="showImport"
        type="button"
        @click="emit('import')"
        class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50"
      >
        <Upload class="h-3.5 w-3.5" />
        Import
      </button>

      <button
        v-if="showExport"
        type="button"
        @click="emit('export')"
        class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50"
      >
        <Download class="h-3.5 w-3.5" />
        Export
      </button>

      <slot name="actions" />
    </div>
  </div>
</template>