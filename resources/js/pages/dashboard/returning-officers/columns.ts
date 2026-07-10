import type { Column } from '@/components/tables/DataTable.vue'

export const columns: Column[] = [
  { key: 'officer', label: 'Officer', sortable: true, sortKey: 'first_name', slot: 'officer' },
  { key: 'institution', label: 'Institution', sortable: true, sortKey: 'institution', slot: 'institution' },
  { key: 'posting', label: 'Posting Location', sortable: true, sortKey: 'posting_location', slot: 'posting' },
  { key: 'location', label: 'Location', slot: 'location' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]