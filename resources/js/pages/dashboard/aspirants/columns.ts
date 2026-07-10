import type { Column } from '@/components/tables/DataTable.vue'

export const columns: Column[] = [
  { key: 'aspirant', label: 'Aspirant', sortable: true, sortKey: 'first_name', slot: 'aspirant' },
  { key: 'office', label: 'Office', sortable: true, sortKey: 'office', slot: 'office' },
  { key: 'constituency', label: 'Constituency', slot: 'constituency' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]