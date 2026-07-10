<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import { Plus } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/components/tables/DataTable.vue'
import DataTableToolbar from '@/components/tables/DataTableToolbar.vue'
import DataTablePagination from '@/components/tables/DataTablePagination.vue'
import BulkActions from '@/components/tables/BulkActions.vue'
import UserAvatarCell from '@/components/tables/UserAvatarCell.vue'
import StatusBadge from '@/components/tables/StatusBadge.vue'
import ActionDropdown from '@/components/tables/ActionDropdown.vue'
import MemberStats from './components/MemberStats.vue'
import MemberFilters from './components/MemberFilters.vue'
import CreateMember from './CreateMember.vue'
import EditMember from './EditMember.vue'
import ViewMember from './ViewMember.vue'
import { columns } from './columns'
import { useDataTable } from '@/composables/table/useDataTable'
import type { Member, MemberStatistics, MemberFilterOptions, LocationOption } from '@/types/member'
import type { DataTableResponse } from '@/types/table'

interface FormOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  pus: LocationOption[]
}

interface Props {
  members: DataTableResponse<Member>
  statistics: MemberStatistics
  filterOptions: MemberFilterOptions
  formOptions: FormOptions
  filters: Record<string, string>
}

const props = withDefaults(defineProps<Props>(), {
  filters: () => ({}),
  filterOptions: () => ({ states: [], zones: [], lgas: [], wards: [], statuses: [] }),
  formOptions: () => ({ states: [], zones: [], lgas: [], wards: [], pus: [] }),
})

const table = useDataTable()

table.search.value = props.filters?.search ?? ''
table.filters.value = {
  state: props.filters?.state ?? '',
  zone: props.filters?.zone ?? '',
  lga: props.filters?.lga ?? '',
  ward: props.filters?.ward ?? '',
  status: props.filters?.status ?? '',
}

function query() {
  router.get(
    route('members.index'),
    {
      search: table.search.value,
      ...table.filters.value,
      sort_by: table.sortBy.value,
      sort_direction: table.sortDirection.value,
      page: table.page.value,
      per_page: table.perPage.value,
    },
    { preserveState: true, preserveScroll: true, replace: true },
  )
}

let debounce: ReturnType<typeof setTimeout>
watch(table.search, () => {
  clearTimeout(debounce)
  table.page.value = 1
  debounce = setTimeout(query, 350)
})
watch(table.filters, () => {
  table.page.value = 1
  query()
}, { deep: true })
watch([table.sortBy, table.sortDirection, table.page, table.perPage], query)

/* ---------------------------------------------------------------------- */
/* Panel state — Create, Edit, and View are now fully independent         */
/* ---------------------------------------------------------------------- */
const creating = ref(false)
const editingMember = ref<Member | null>(null)

const viewingMemberId = ref<number | string | null>(null)
const viewingMember = computed(() =>
  viewingMemberId.value === null
    ? null
    : props.members.data.find((m) => m.id === viewingMemberId.value) ?? null,
)

function openCreate() {
  creating.value = true
}

function closeCreate() {
  creating.value = false
}

function openEdit(member: Member) {
  editingMember.value = member
}

function closeEdit() {
  editingMember.value = null
}

function openView(row: Member) {
  viewingMemberId.value = row.id
}

function closeView() {
  viewingMemberId.value = null
}

function editFromView(member: Member) {
  closeView()
  openEdit(member)
}

/* ---------------------------------------------------------------------- */
/* Row / bulk actions                                                     */
/* ---------------------------------------------------------------------- */
function handleRowAction(key: string, row: Member) {
  if (key === 'view') return openView(row)
  if (key === 'edit') return openEdit(row)
  if (key === 'delete' && confirm(`Delete ${row.first_name} ${row.last_name}?`)) {
    router.delete(route('members.destroy', row.id), { preserveScroll: true })
  }
}

function handleBulkAction(key: string) {
  if (key === 'delete' && confirm(`Delete ${table.selected.value.length} members?`)) {
    router.post(
      route('members.bulk-destroy'),
      { ids: table.selected.value },
      { preserveScroll: true, onSuccess: table.clearSelection },
    )
  }
}

function toggleAll() {
  const ids = props.members.data.map((m) => m.id)
  const allSelected = ids.every((id) => table.selected.value.includes(id))
  table.selected.value = allSelected ? [] : ids
}
</script>

<template>
  <Head title="Members" />
  <AppLayout>
    <div class="space-y-4 sm:space-y-6">
      <!-- Header -->
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
        <div class="min-w-0">
          <h2 class="text-lg font-black text-gray-900 sm:text-xl">Members</h2>
          <p class="mt-1 text-xs font-medium text-gray-500 sm:text-sm">
            Manage registered members across states, LGAs and wards
          </p>
        </div>
        <button
          type="button"
          @click="openCreate"
          class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-green-800 active:bg-green-900 sm:w-auto sm:py-2 sm:text-sm flex-shrink-0"
        >
          <Plus class="h-4 w-4" />
          Add Member
        </button>
      </div>

      <MemberStats :statistics="statistics" />

      <DataTableToolbar
        v-model="table.search.value"
        placeholder="Search by name, email, phone or member no..."
        show-export
        show-refresh
        @refresh="query"
        @export="router.get(route('members.export'), { ...table.filters.value })"
      >
        <template #filters>
          <MemberFilters v-model="table.filters.value" :options="filterOptions" />
        </template>
      </DataTableToolbar>

      <BulkActions
        :selected="table.selected.value"
        @clear="table.clearSelection"
        @action="handleBulkAction"
      />

      <div class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:overflow-visible sm:px-0">
        <div class="min-w-[720px] sm:min-w-0">
          <DataTable
            :columns="columns"
            :rows="members.data"
            :selected="table.selected.value"
            :sort-by="table.sortBy.value"
            :sort-direction="table.sortDirection.value"
            @toggle-selection="table.toggleSelection"
            @toggle-all="toggleAll"
            @sort="table.toggleSort"
          >
            <template #member="{ row }">
              <UserAvatarCell
                :first-name="row.first_name"
                :middle-name="row.middle_name"
                :last-name="row.last_name"
                :avatar-url="row.avatar_url"
                :subtitle="row.member_no"
              />
            </template>
            <template #location="{ row }">
              <div class="text-sm text-gray-700">{{ row.lga }} LGA</div>
              <div class="text-xs text-gray-400">{{ row.ward }} Ward</div>
            </template>
            <template #mentor="{ row }">
              <span class="text-sm text-gray-700">{{ row.mentor ?? '—' }}</span>
            </template>
            <template #training="{ row }">
              <StatusBadge :status="row.training_status_label" />
            </template>
            <template #status="{ row }">
              <StatusBadge :status="row.status" />
            </template>
            <template #actions="{ row }">
              <div class="flex justify-end">
                <ActionDropdown @action="(key) => handleRowAction(key, row)" />
              </div>
            </template>
          </DataTable>
        </div>
      </div>

      <DataTablePagination
        :current-page="members.meta?.current_page ?? 1"
        :last-page="members.meta?.last_page ?? 1"
        :from="members.meta?.from ?? null"
        :to="members.meta?.to ?? null"
        :per-page="members.meta?.per_page ?? 15"
        :total="members.meta?.total ?? members.data.length"
        @update:current-page="table.page.value = $event"
        @update:per-page="table.perPage.value = $event"
      />
    </div>

    <CreateMember
      :open="creating"
      :form-options="formOptions"
      @close="closeCreate"
    />

    <EditMember
      :member="editingMember"
      :form-options="formOptions"
      @close="closeEdit"
    />

    <ViewMember
      v-if="viewingMember"
      :member="viewingMember"
      @close="closeView"
      @edit="editFromView"
    />
  </AppLayout>
</template>