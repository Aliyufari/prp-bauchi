<script setup lang="ts">
import { computed } from 'vue'
import DataTableFilters, { type FilterDef } from '@/components/tables/DataTableFilters.vue'
import type { AspirantFilterOptions } from '@/types/aspirant'

interface Props {
  modelValue: Record<string, string>
  options: AspirantFilterOptions
}
const props = defineProps<Props>()
const emit = defineEmits<{ 'update:modelValue': [value: Record<string, string>] }>()

const filters = computed<FilterDef[]>(() => [
  { key: 'office', label: 'Office', options: props.options.offices },
  { key: 'status', label: 'Status', options: props.options.statuses },
])
</script>

<template>
  <DataTableFilters
    :filters="filters"
    :model-value="modelValue"
    @update:model-value="emit('update:modelValue', $event)"
  />
</template>