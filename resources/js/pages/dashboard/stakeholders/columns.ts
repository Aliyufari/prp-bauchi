import type { Column } from '@/components/tables/DataTable.vue'

export const columns: Column[] = [
  { key: 'stakeholder', label: 'Stakeholder', sortable: true, sortKey: 'first_name', slot: 'stakeholder' },
  { key: 'type', label: 'Category', sortable: true, sortKey: 'stakeholder_type', slot: 'type' },
  { key: 'organization', label: 'Organization', slot: 'organization' },
  { key: 'location', label: 'Location', slot: 'location' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]