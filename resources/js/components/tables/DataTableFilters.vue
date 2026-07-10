<script setup lang="ts">
import { computed } from 'vue'
import { SlidersHorizontal, ChevronDown, X } from 'lucide-vue-next'

export interface FilterOption {
  value: string
  label: string
}

export interface FilterDef {
  key: string
  label: string
  options: FilterOption[]
}

interface Props {
  filters: FilterDef[]
  modelValue: Record<string, string>
}

const props = defineProps<Props>()
const emit = defineEmits<{ 'update:modelValue': [value: Record<string, string>] }>()

function set(key: string, value: string) {
  emit('update:modelValue', { ...props.modelValue, [key]: value })
}

function clearAll() {
  const cleared: Record<string, string> = {}
  props.filters.forEach((f) => (cleared[f.key] = ''))
  emit('update:modelValue', cleared)
}

function clearOne(key: string) {
  emit('update:modelValue', { ...props.modelValue, [key]: '' })
}

function labelFor(filter: FilterDef) {
  const val = props.modelValue[filter.key]
  if (!val) return `All ${filter.label}`
  return filter.options.find((o) => o.value === val)?.label ?? filter.label
}

const activeCount = computed(() => Object.values(props.modelValue).filter(Boolean).length)
</script>

<template>
  <div class="flex flex-wrap items-center gap-2">
    <!-- Icon tag, purely decorative context -->
    <span
      class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-gray-400 flex-shrink-0"
    >
      <SlidersHorizontal class="h-3.5 w-3.5" />
      Filters
    </span>

    <div
      v-for="filter in filters"
      :key="filter.key"
      class="relative flex-shrink-0"
    >
      <select
        :value="modelValue[filter.key]"
        @change="set(filter.key, ($event.target as HTMLSelectElement).value)"
        :class="[
          'appearance-none rounded-full border pl-3 pr-8 py-2 text-xs font-semibold shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 cursor-pointer max-w-[9.5rem] sm:max-w-[11rem] truncate',
          modelValue[filter.key]
            ? 'border-green-200 bg-green-50 text-green-800'
            : 'border-gray-200 bg-white text-gray-600 hover:bg-gray-50',
        ]"
      >
        <option value="">All {{ filter.label }}</option>
        <option v-for="opt in filter.options" :key="opt.value" :value="opt.value">
          {{ opt.label }}
        </option>
      </select>

      <!-- Chevron / clear icon overlay -->
      <button
        v-if="modelValue[filter.key]"
        type="button"
        title="Clear"
        @click="clearOne(filter.key)"
        class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-full p-0.5 text-green-600 hover:bg-green-100 pointer-events-auto"
      >
        <X class="h-3 w-3" />
      </button>
      <ChevronDown
        v-else
        class="pointer-events-none absolute right-2.5 top-1/2 h-3 w-3 -translate-y-1/2 text-gray-400"
      />
    </div>

    <button
      v-if="activeCount"
      type="button"
      @click="clearAll"
      class="inline-flex flex-shrink-0 items-center gap-1 rounded-full px-2.5 py-2 text-xs font-semibold text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600"
    >
      <X class="h-3 w-3" />
      Clear all
    </button>
  </div>
</template>