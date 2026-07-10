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
import AspirantStats from './components/AspirantStats.vue'
import AspirantFilters from './components/AspirantFilters.vue'
import AspirantForm from './components/AspirantForm.vue'
import { columns } from './columns'
import { useDataTable } from '@/composables/table/useDataTable'
import type { Aspirant, AspirantStatistics, AspirantFilterOptions, AspirantOfficeOption, ConstituencyOption } from '@/types/aspirant'
import type { DataTableResponse } from '@/types/table'

interface FormOptions {
  constituencies: ConstituencyOption[]
  offices: AspirantOfficeOption[]
}

interface Props {
  aspirants: DataTableResponse<Aspirant>
  statistics: AspirantStatistics
  filterOptions: AspirantFilterOptions
  formOptions: FormOptions
  filters: Record<string, string>
}

const props = withDefaults(defineProps<Props>(), {
  filters: () => ({}),
  filterOptions: () => ({ offices: [], statuses: [] }),
  formOptions: () => ({ constituencies: [], offices: [] }),
})

const table = useDataTable()

table.search.value = props.filters?.search ?? ''
table.filters.value = {
  office: props.filters?.office ?? '',
  status: props.filters?.status ?? '',
}

function query() {
  router.get(
    route('aspirants.index'),
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
type ModalMode = 'create' | 'edit' | null
const modalMode = ref<ModalMode>(null)
const editingAspirant = ref<Aspirant | null>(null)

function emptyFormValues() {
  return {
    first_name: '',
    middle_name: '' as string | null,
    last_name: '',
    email: '',
    password: '',
    phone: '' as string | null,
    gender: null as string | null,
    education_status: '' as string | null,
    office: '' as string | null,
    constituency_id: null as string | null,
    title: '' as string | null,
    vision: '' as string | null,
    mission: '' as string | null,
    image_url: '' as string | null,
    overall_progress: 0,
    total_supporters: 0,
    supporters_growth_this_week: 0,
    campaign_team_members: 0,
  }
}

const form = useForm(emptyFormValues())

function openCreateModal() {
  editingAspirant.value = null
  form.clearErrors()
  form.defaults(emptyFormValues())
  form.reset()
  modalMode.value = 'create'
}

function openEditModal(row: Aspirant) {
  editingAspirant.value = row
  form.clearErrors()
  const values = {
    first_name: row.first_name,
    middle_name: row.middle_name,
    last_name: row.last_name,
    email: row.email,
    password: '',
    phone: row.phone,
    gender: null,
    education_status: '',
    office: row.office,
    constituency_id: row.constituency_id,
    title: row.title,
    vision: row.vision,
    mission: row.mission,
    image_url: row.image_url,
    overall_progress: row.overall_progress,
    total_supporters: row.total_supporters,
    supporters_growth_this_week: row.supporters_growth_this_week,
    campaign_team_members: row.campaign_team_members,
  }
  form.defaults(values)
  form.reset()
  Object.assign(form, values)
  modalMode.value = 'edit'
}

function closeModal() {
  modalMode.value = null
  editingAspirant.value = null
  form.clearErrors()
}

function submitForm() {
  const options = { preserveScroll: true, onSuccess: () => closeModal() }
  if (modalMode.value === 'create') {
    form.post(route('aspirants.store'), options)
  } else if (modalMode.value === 'edit' && editingAspirant.value) {
    form.patch(route('aspirants.update', editingAspirant.value.id), options)
  }
}

function viewAspirant(row: Aspirant) {
  router.visit(route('aspirants.show', row.id))
}

function handleRowAction(key: string, row: Aspirant) {
  if (key === 'view') return viewAspirant(row)
  if (key === 'edit') return openEditModal(row)
  if (key === 'delete' && confirm(`Delete ${row.first_name} ${row.last_name}?`)) {
    router.delete(route('aspirants.destroy', row.id), { preserveScroll: true })
  }
}

function handleBulkAction(key: string) {
  if (key === 'delete' && confirm(`Delete ${table.selected.value.length} aspirants?`)) {
    router.post(
      route('aspirants.bulk-destroy'),
      { ids: table.selected.value },
      { preserveScroll: true, onSuccess: table.clearSelection },
    )
  }
}

function toggleAll() {
  const ids = props.aspirants.data.map((a) => a.id)
  const allSelected = ids.every((id) => table.selected.value.includes(id))
  table.selected.value = allSelected ? [] : ids
}
</script>

<template>
  <Head title="All Aspirants" />
  <AppLayout>
    <div class="space-y-4 sm:space-y-6">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
        <div class="min-w-0">
          <h2 class="text-lg font-black text-gray-900 sm:text-xl">All Aspirants</h2>
          <p class="mt-1 text-xs font-medium text-gray-500 sm:text-sm">
            Manage aspirants across all elective offices and constituencies
          </p>
        </div>
        <button
          type="button"
          @click="openCreateModal"
          class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-green-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-green-800 active:bg-green-900 sm:w-auto sm:py-2 sm:text-sm flex-shrink-0"
        >
          <Plus class="h-4 w-4" />
          Add Aspirant
        </button>
      </div>

      <AspirantStats :statistics="statistics" />

      <DataTableToolbar
        v-model="table.search.value"
        placeholder="Search by name or email..."
        show-export
        show-refresh
        @refresh="query"
        @export="router.get(route('aspirants.export'), { ...table.filters.value })"
      >
        <template #filters>
          <AspirantFilters v-model="table.filters.value" :options="filterOptions" />
        </template>
      </DataTableToolbar>

      <BulkActions :selected="table.selected.value" @clear="table.clearSelection" @action="handleBulkAction" />

      <div class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:overflow-visible sm:px-0">
        <div class="min-w-[720px] sm:min-w-0">
          <DataTable
            :columns="columns"
            :rows="aspirants.data"
            :selected="table.selected.value"
            :sort-by="table.sortBy.value"
            :sort-direction="table.sortDirection.value"
            @toggle-selection="table.toggleSelection"
            @toggle-all="toggleAll"
            @sort="table.toggleSort"
          >
            <template #aspirant="{ row }">
              <UserAvatarCell
                :first-name="row.first_name"
                :middle-name="row.middle_name"
                :last-name="row.last_name"
                :avatar-url="row.image_url"
                :subtitle="row.email"
              />
            </template>
            <template #office="{ row }">
              <span class="text-sm text-gray-700">{{ row.office_label ?? '—' }}</span>
            </template>
            <template #constituency="{ row }">
              <span class="text-sm text-gray-700">{{ row.constituency ?? '—' }}</span>
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
        :current-page="aspirants.meta.current_page"
        :last-page="aspirants.meta.last_page"
        :from="aspirants.meta.from"
        :to="aspirants.meta.to"
        :per-page="aspirants.meta.per_page"
        :total="aspirants.meta.total"
        @update:current-page="table.page.value = $event"
        @update:per-page="table.perPage.value = $event"
      />
    </div>

    <SlideOver
      :open="modalMode !== null"
      :title="modalMode === 'create' ? 'Add Aspirant' : 'Edit Aspirant'"
      :description="
        modalMode === 'create'
          ? 'Register a new aspirant and their candidacy.'
          : editingAspirant
            ? `Update details for ${editingAspirant.first_name} ${editingAspirant.last_name}.`
            : ''
      "
      size="lg"
      side="right"
      @close="closeModal"
    >
      <AspirantForm
        v-if="modalMode"
        :form="form"
        :submit-label="modalMode === 'create' ? 'Create aspirant' : 'Save changes'"
        :password-optional="modalMode === 'edit'"
        :constituencies="formOptions.constituencies"
        :offices="formOptions.offices"
        @submit="submitForm"
        @cancel="closeModal"
      />
    </SlideOver>
  </AppLayout>
</template>