import type { Column } from '@/components/tables/DataTable.vue'

export const columns: Column[] = [
  { key: 'coordinator', label: 'Coordinator', sortable: true, sortKey: 'first_name', slot: 'coordinator' },
  { key: 'type', label: 'Type', sortable: true, sortKey: 'coordinator_type', slot: 'type' },
  { key: 'location', label: 'Location', slot: 'location' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]