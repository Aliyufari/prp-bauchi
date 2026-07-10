import type { Column } from '@/components/tables/DataTable.vue'

export const columns: Column[] = [
  { key: 'agent', label: 'Supervisor', sortable: true, sortKey: 'first_name', slot: 'agent' },
  { key: 'type', label: 'Level', sortable: true, sortKey: 'supervisor_type', slot: 'type' },
  { key: 'supervised', label: 'Agents Supervised', sortable: true, sortKey: 'agents_supervised', slot: 'supervised' },
  { key: 'location', label: 'Location', slot: 'location' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]