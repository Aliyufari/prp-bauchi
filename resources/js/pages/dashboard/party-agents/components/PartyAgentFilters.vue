<script setup lang="ts">
import { computed } from 'vue'
import DataTableFilters, { type FilterDef } from '@/components/tables/DataTableFilters.vue'
import type { PartyAgentFilterOptions } from '@/types/party-agent'

interface Props {
  modelValue: Record<string, string>
  options: PartyAgentFilterOptions
}
const props = defineProps<Props>()
const emit = defineEmits<{ 'update:modelValue': [value: Record<string, string>] }>()

const filters = computed<FilterDef[]>(() => [
  { key: 'state', label: 'States', options: props.options.states.map((s) => ({ value: s.id, label: s.name })) },
  { key: 'zone', label: 'Zones', options: props.options.zones.map((z) => ({ value: z.id, label: z.name })) },
  { key: 'lga', label: 'LGAs', options: props.options.lgas.map((l) => ({ value: l.id, label: l.name })) },
  { key: 'ward', label: 'Wards', options: props.options.wards.map((w) => ({ value: w.id, label: w.name })) },
  { key: 'type', label: 'Type', options: props.options.types },
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