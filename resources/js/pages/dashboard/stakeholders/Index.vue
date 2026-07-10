<script setup lang="ts">
import { ref, watch } from 'vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { Plus } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import DataTable from '@/components/tables/DataTable.vue'
import DataTableToolbar from '@/components/tables/DataTableToolbar.vue'
import DataTablePagination from '@/components/tables/DataTablePagination.vue'
import BulkActions from '@/components/tables/BulkActions.vue'
import UserAvatarCell from '@/components/tables/UserAvatarCell.vue'
import StatusBadge from '@/components/tables/StatusBadge.vue'
import ActionDropdown from '@/components/tables/ActionDropdown.vue'
import SlideOver from '@/components/ui/SlideOver.vue'
import StakeholderStats from './components/StakeholderStats.vue'
import StakeholderFilters from './components/StakeholderFilters.vue'
import StakeholderForm from './components/StakeholderForm.vue'
import { columns } from './columns'
import { useDataTable } from '@/composables/table/useDataTable'
import type { Stakeholder, StakeholderStatistics, StakeholderFilterOptions, StakeholderTypeOption } from '@/types/stakeholder'
import type { LocationOption } from '@/types/member'
import type { DataTableResponse } from '@/types/table'

interface FormOptions {
  states: LocationOption[]
  zones: LocationOption[]
  lgas: LocationOption[]
  wards: LocationOption[]
  pus: LocationOption[]
  types: StakeholderTypeOption[]
}

interface Props {
  stakeholders: DataTableResponse<Stakeholder>
  statistics: StakeholderStatistics
  filterOptions: StakeholderFilterOptions
  formOptions: FormOptions
  filters: Record<string, string>
}

const props = withDefaults(defineProps<Props>(), {
  filters: () => ({}),
  filterOptions: () => ({ states: [], zones: [], lgas: [], wards: [], statuses: [], types: [] }),
  formOptions: () => ({ states: [], zones: [], lgas: [], wards: [], pus: [], types: [] }),
})

const table = useDataTable()

table.search.value = props.filters?.search ?? ''
table.filters.value = {
  state: props.filters?.state ?? '',
  zone: props.filters?.zone ?? '',
  lga: props.filters?.lga ?? '',
  ward: props.filters?.ward ?? '',
  status: props.filters?.status ?? '',
  type: props.filters?.type ?? '',
}

function query() {
  router.get(
    route('stakeholders.index'),
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
/* Create / Edit modal                                                    */
/* ---------------------------------------------------------------------- */
type ModalMode = 'create' | 'edit' | null
const modalMode = ref<ModalMode>(null)
const editingStakeholder = ref<Stakeholder | null>(null)

function emptyFormValues() {
  return {
    first_name: '',
    middle_name: '' as string | null,
    last_name: '',
    email: '',
    password: '',
    phone: '' as string | null,
    gender: null as string | null,
    occupation: '' as string | null,
    education_status: '' as string | null,
    application_id: '' as string | null,
    type: '' as string | null,
    organization: '' as string | null,
    designation: '' as string | null,
    state_id: null as number | string | null,
    zone_id: null as number | string | null,
    lga_id: null as number | string | null,
    ward_id: null as number | string | null,
    pu_id: null as number | string | null,
  }
}

const form = useForm(emptyFormValues())

function openCreateModal() {
  editingStakeholder.value = null
  form.clearErrors()
  form.defaults(emptyFormValues())
  form.reset()
  modalMode.value = 'create'
}

function openEditModal(row: Stakeholder) {
  editingStakeholder.value = row
  form.clearErrors()
  const values = {
    first_name: row.first_name,
    middle_name: row.middle_name,
    last_name: row.last_name,
    email: row.email,
    password: '',
    phone: row.phone,
    gender: row.gender,
    occupation: row.occupation,
    education_status: row.education_status,
    application_id: row.stakeholder_no,
    type: row.stakeholder_type,
    organization: row.organization,
    designation: row.designation,
    state_id: row.state_id,
    zone_id: row.zone_id,
    lga_id: row.lga_id,
    ward_id: row.ward_id,
    pu_id: row.pu_id,
  }
  form.defaults(values)
  form.reset()
  Object.assign(form, values)
  modalMode.value = 'edit'
}

function closeModal() {
  modalMode.value = null
  editingStakeholder.value = null
  form.clearErrors()
}

function submitForm() {
  const options = {
    preserveScroll: true,
    onSuccess: () => closeModal(),
  }
  if (modalMode.value === 'create') {
    form.post(route('stakeholders.store'), options)
  } else if (modalMode.value === 'edit' && editingStakeholder.value) {
    form.patch(route('stakeholders.update', editingStakeholder.value.id), options)
  }
}

/* ---------------------------------------------------------------------- */
/* Row / bulk actions                                                     */
/* ---------------------------------------------------------------------- */
function viewStakeholder(row: Stakeholder) {
  router.visit(route('stakeholders.show', row.id))
}

function handleRowAction(key: string, row: Stakeholder) {
  if (key === 'view') return viewStakeholder(row)
  if (key === 'edit') return openEditModal(row)
  if (key === 'delete' && confirm(`Delete ${row.first_name} ${row.last_name}?`)) {
    router.delete(route('stakeholders.destroy', row.id), { preserveScroll: true })
  }
}

function handleBulkAction(key: string) {
  if (key === 'delete' && confirm(`Delete ${table.selected.value.length} stakeholders?`)) {
    router.post(
      route('stakeholders.bulk-destroy'),
      { ids: table.selected.value },
      { preserveScroll: true, onSuccess: table.clearSelection },
    )
  }
}

function toggleAll() {
  const ids = props.stakeholders.data.map((s) => s.id)
  const allSelected = ids.every((id) => table.selected.value.includes(id))
  table.selected.value = allSelected ? [] : ids
}
</script>

<template>
  <Head title="Stakeholders" />
  <AppLayout>
    <div class="space-y-4 sm:space-y-6">
      <!-- Header -->
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
        <div class="min-w-0">
          <h2 class="text-lg font-black text-gray-900 sm:text-xl">Stakeholders</h2>
          <p class="mt-1 text-xs font-medium text-gray-500 sm:text-sm">
            Manage traditional rulers, community and organizational stakeholders
          </p>
        </div>
        <button
          type="button"
          @click="openCreateModal"
          class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-green-800 active:bg-green-900 sm:w-auto sm:py-2 sm:text-sm flex-shrink-0"
        >
          <Plus class="h-4 w-4" />
          Add Stakeholder
        </button>
      </div>

      <!-- Stats -->
      <StakeholderStats :statistics="statistics" />

      <!-- Toolbar + filters -->
      <DataTableToolbar
        v-model="table.search.value"
        placeholder="Search by name, email, phone or organization..."
        show-export
        show-refresh
        @refresh="query"
        @export="router.get(route('stakeholders.export'), { ...table.filters.value })"
      >
        <template #filters>
          <StakeholderFilters v-model="table.filters.value" :options="filterOptions" />
        </template>
      </DataTableToolbar>

      <!-- Bulk actions -->
      <BulkActions
        :selected="table.selected.value"
        @clear="table.clearSelection"
        @action="handleBulkAction"
      />

      <!-- Table -->
      <div class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:overflow-visible sm:px-0">
        <div class="min-w-[720px] sm:min-w-0">
          <DataTable
            :columns="columns"
            :rows="stakeholders.data"
            :selected="table.selected.value"
            :sort-by="table.sortBy.value"
            :sort-direction="table.sortDirection.value"
            @toggle-selection="table.toggleSelection"
            @toggle-all="toggleAll"
            @sort="table.toggleSort"
          >
            <template #stakeholder="{ row }">
              <UserAvatarCell
                :first-name="row.first_name"
                :middle-name="row.middle_name"
                :last-name="row.last_name"
                :avatar-url="row.avatar_url"
                :subtitle="row.stakeholder_no"
              />
            </template>
            <template #type="{ row }">
              <span class="text-sm text-gray-700">{{ row.stakeholder_type_label ?? '—' }}</span>
            </template>
            <template #organization="{ row }">
              <div class="text-sm text-gray-700">{{ row.organization ?? '—' }}</div>
              <div v-if="row.designation" class="text-xs text-gray-400">{{ row.designation }}</div>
            </template>
            <template #location="{ row }">
              <div class="text-sm text-gray-700">{{ row.lga ?? '—' }} LGA</div>
              <div class="text-xs text-gray-400">{{ row.ward ?? '—' }} Ward</div>
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

      <!-- Pagination -->
      <DataTablePagination
        :current-page="stakeholders.meta.current_page"
        :last-page="stakeholders.meta.last_page"
        :from="stakeholders.meta.from"
        :to="stakeholders.meta.to"
        :per-page="stakeholders.meta.per_page"
        :total="stakeholders.meta.total"
        @update:current-page="table.page.value = $event"
        @update:per-page="table.perPage.value = $event"
      />
    </div>

    <!-- Create / Edit modal -->
    <SlideOver
      :open="modalMode !== null"
      :title="modalMode === 'create' ? 'Add Stakeholder' : 'Edit Stakeholder'"
      :description="
        modalMode === 'create'
          ? 'Register a new stakeholder and their organization.'
          : editingStakeholder
            ? `Update details for ${editingStakeholder.first_name} ${editingStakeholder.last_name}.`
            : ''
      "
      size="lg"
      side="right"
      @close="closeModal"
    >
      <StakeholderForm
        v-if="modalMode"
        :form="form"
        :submit-label="modalMode === 'create' ? 'Create stakeholder' : 'Save changes'"
        :password-optional="modalMode === 'edit'"
        :states="formOptions.states"
        :zones="formOptions.zones"
        :lgas="formOptions.lgas"
        :wards="formOptions.wards"
        :pus="formOptions.pus"
        :types="formOptions.types"
        @submit="submitForm"
        @cancel="closeModal"
      />
    </SlideOver>
  </AppLayout>
</template>