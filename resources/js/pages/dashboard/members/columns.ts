import type { Column } from '@/components/tables/DataTable.vue'
import type { Member } from '@/types/member'

export const columns: Column[] = [
  { key: 'member', label: 'Member', sortable: true, sortKey: 'first_name', slot: 'member' },
  { key: 'location', label: 'Location', slot: 'location' },
  { key: 'mentor', label: 'Mentor', sortable: true, sortKey: 'mentor_name', slot: 'mentor' },
  { key: 'training', label: 'Training', sortable: true, sortKey: 'training_status', slot: 'training' },
  { key: 'status', label: 'Status', sortable: true, slot: 'status' },
  { key: 'actions', label: '', slot: 'actions', class: 'text-right' },
]