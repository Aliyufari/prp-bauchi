<script setup lang="ts">
import { ArrowUp, ArrowDown, ArrowUpDown } from 'lucide-vue-next'
import DataTableEmpty from './DataTableEmpty.vue'

// interface Column {
//   key: string
//   label: string
//   sortable?: boolean
//   slot?: string
//   class?: string
//   hideOnMobile?: boolean
// }

export interface Column {
  key: string
  label: string
  sortable?: boolean
  sortKey?: string
  slot?: string
  class?: string
  hideOnMobile?: boolean
}

interface Props {
  columns: Column[]
  rows: Record<string, any>[]
  selected?: (string | number)[]
  sortBy?: string
  sortDirection?: 'asc' | 'desc'
  rowKey?: string
  selectable?: boolean
  loading?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  selected: () => [],
  rowKey: 'id',
  selectable: true,
  loading: false,
})

const emit = defineEmits<{
  'toggle-selection': [id: string | number]
  'toggle-all': []
  sort: [column: string]
}>()

function isSelected(id: string | number) {
  return props.selected.includes(id)
}

const allSelected = () =>
  props.rows.length > 0 && props.rows.every((r) => isSelected(r[props.rowKey]))
</script>

<template>
  <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
    <!-- ================= DESKTOP / TABLET TABLE ================= -->
    <div class="hidden overflow-x-auto md:block">
      <table class="w-full text-left">
        <thead>
          <tr class="border-b border-gray-100 bg-gray-50/60">
            <th v-if="selectable" class="w-10 px-4 py-3">
              <input
                type="checkbox"
                :checked="allSelected()"
                @change="emit('toggle-all')"
                class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-500"
              />
            </th>
            <th
              v-for="col in columns"
              :key="col.key"
              class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500"
              :class="col.class"
            >
              <button
                v-if="col.sortable"
                type="button"
                class="inline-flex items-center gap-1 hover:text-gray-700"
                @click="emit('sort', col.sortKey ?? col.key)"
              >
                {{ col.label }}
                <ArrowUp v-if="sortBy === (col.sortKey ?? col.key) && sortDirection === 'asc'" class="h-3 w-3" />
                <ArrowDown v-else-if="sortBy === (col.sortKey ?? col.key) && sortDirection === 'desc'" class="h-3 w-3" />
                <ArrowUpDown v-else class="h-3 w-3 text-gray-300" />
              </button>
              <span v-else>{{ col.label }}</span>
            </th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="row in rows"
            :key="row[rowKey]"
            class="border-b border-gray-50 last:border-0 transition hover:bg-gray-50/60"
          >
            <td v-if="selectable" class="w-10 px-4 py-3">
              <input
                type="checkbox"
                :checked="isSelected(row[rowKey])"
                @change="emit('toggle-selection', row[rowKey])"
                class="h-4 w-4 rounded border-gray-300 text-green-700 focus:ring-green-500"
              />
            </td>
            <td v-for="col in columns" :key="col.key" class="px-4 py-3 align-middle" :class="col.class">
              <slot v-if="col.slot" :name="col.slot" :row="row" />
              <span v-else class="text-sm text-gray-700">{{ row[col.key] }}</span>
            </td>
          </tr>
        </tbody>
      </table>

      <DataTableEmpty v-if="!loading && rows.length === 0" />
    </div>

    <!-- ================= MOBILE CARD LIST ================= -->
    <div class="divide-y divide-gray-50 md:hidden">
      <div v-for="row in rows" :key="row[rowKey]" class="flex gap-3 p-4">
        <input
          v-if="selectable"
          type="checkbox"
          :checked="isSelected(row[rowKey])"
          @change="emit('toggle-selection', row[rowKey])"
          class="mt-1 h-4 w-4 shrink-0 rounded border-gray-300 text-green-700 focus:ring-green-500"
        />
        <div class="min-w-0 flex-1 space-y-2">
          <template v-for="col in columns.filter((c) => !c.hideOnMobile)" :key="col.key">
            <div v-if="col.slot === 'member' || col.slot === 'actions'">
              <slot :name="col.slot" :row="row" />
            </div>
            <div v-else class="flex items-center justify-between gap-2 text-xs">
              <span class="font-medium text-gray-400">{{ col.label }}</span>
              <span v-if="!col.slot" class="text-right font-medium text-gray-700">{{ row[col.key] }}</span>
              <slot v-else :name="col.slot" :row="row" />
            </div>
          </template>
        </div>
      </div>

      <DataTableEmpty v-if="!loading && rows.length === 0" />
    </div>
  </div>
</template>