<script setup lang="ts">
import { ArrowUp, ArrowDown, ArrowUpDown } from 'lucide-vue-next'
import DataTableEmpty from './DataTableEmpty.vue'

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

// Split mobile columns into identity (member), footer (actions), and plain data rows
function mobileDataColumns(cols: Column[]) {
  return cols.filter((c) => !c.hideOnMobile && c.slot !== 'member' && c.slot !== 'actions')
}
function memberColumn(cols: Column[]) {
  return cols.find((c) => c.slot === 'member' && !c.hideOnMobile)
}
function actionsColumn(cols: Column[]) {
  return cols.find((c) => c.slot === 'actions' && !c.hideOnMobile)
}
</script>

<template>
  <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
    <!-- ================= DESKTOP / TABLET TABLE ================= -->
    <div class="hidden overflow-x-auto md:block">
      <table class="w-full min-w-[640px] text-left">
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
              class="whitespace-nowrap px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500"
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
      <div v-for="row in rows" :key="row[rowKey]" class="p-4">
        <div class="flex items-start gap-3">
          <input
            v-if="selectable"
            type="checkbox"
            :checked="isSelected(row[rowKey])"
            @change="emit('toggle-selection', row[rowKey])"
            class="mt-1 h-4 w-4 shrink-0 rounded border-gray-300 text-green-700 focus:ring-green-500"
          />

          <div class="min-w-0 flex-1">
            <!-- Identity header (member slot) -->
            <div v-if="memberColumn(columns)" class="min-w-0">
              <slot :name="memberColumn(columns)!.slot" :row="row" />
            </div>

            <!-- Data rows -->
            <div
              v-if="mobileDataColumns(columns).length"
              class="mt-3 space-y-1.5"
              :class="memberColumn(columns) ? 'border-t border-gray-50 pt-3' : ''"
            >
              <div
                v-for="col in mobileDataColumns(columns)"
                :key="col.key"
                class="flex items-start justify-between gap-3 text-xs"
              >
                <span class="shrink-0 font-medium text-gray-400">{{ col.label }}</span>
                <span v-if="!col.slot" class="min-w-0 truncate text-right font-medium text-gray-700">
                  {{ row[col.key] }}
                </span>
                <span v-else class="min-w-0 text-right">
                  <slot :name="col.slot" :row="row" />
                </span>
              </div>
            </div>

            <!-- Actions footer -->
            <div
              v-if="actionsColumn(columns)"
              class="mt-3 flex flex-wrap items-center justify-end gap-2 border-t border-gray-50 pt-3"
            >
              <slot :name="actionsColumn(columns)!.slot" :row="row" />
            </div>
          </div>
        </div>
      </div>

      <DataTableEmpty v-if="!loading && rows.length === 0" />
    </div>
  </div>
</template>