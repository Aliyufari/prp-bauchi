import type { Column } from '@/components/tables/DataTable.vue'
import type { PartyAgent } from '@/types/party-agent'

export const columns: Column[] = [
  { key: 'agent', label: 'Agent', sortable: true, sortKey: 'first_name', slot: 'agent' },
  { key: 'type', label: 'Type', sortable: true, sortKey: 'agent_type', slot: 'type' },
  { key: 'location', label: 'Location', slot: 'location' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]