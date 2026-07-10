<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import { Pencil, Users, TrendingUp, UserCog, MapPin } from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import SlideOver from '@/components/ui/SlideOver.vue'
import AspirantForm from './components/AspirantForm.vue'
import type { Aspirant, AspirantOfficeOption, ConstituencyOption } from '@/types/aspirant'
import aspirantImage from '@/assets/images/governor-aspirant.jpeg'

interface FormOptions {
  constituencies: ConstituencyOption[]
  offices: AspirantOfficeOption[]
}

interface Props {
  aspirant: Aspirant | null
  formOptions: FormOptions
}
const props = defineProps<Props>()

const heroImage = computed(() => props.aspirant?.image_url || aspirantImage)
const fullName = computed(() =>
  props.aspirant
    ? [props.aspirant.first_name, props.aspirant.middle_name, props.aspirant.last_name].filter(Boolean).join(' ')
    : '',
)

const modalOpen = ref(false)

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
    office: 'governor',
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

function openEdit() {
  form.clearErrors()
  const values = props.aspirant
    ? {
        first_name: props.aspirant.first_name,
        middle_name: props.aspirant.middle_name,
        last_name: props.aspirant.last_name,
        email: props.aspirant.email,
        password: '',
        phone: props.aspirant.phone,
        gender: null,
        education_status: '',
        office: 'governor',
        constituency_id: props.aspirant.constituency_id,
        title: props.aspirant.title,
        vision: props.aspirant.vision,
        mission: props.aspirant.mission,
        image_url: props.aspirant.image_url,
        overall_progress: props.aspirant.overall_progress,
        total_supporters: props.aspirant.total_supporters,
        supporters_growth_this_week: props.aspirant.supporters_growth_this_week,
        campaign_team_members: props.aspirant.campaign_team_members,
      }
    : emptyFormValues()

  form.defaults(values)
  form.reset()
  Object.assign(form, values)
  modalOpen.value = true
}

function closeModal() {
  modalOpen.value = false
  form.clearErrors()
}

function submitForm() {
  const options = { preserveScroll: true, onSuccess: () => closeModal() }
  if (props.aspirant) {
    form.patch(route('aspirants.update', props.aspirant.id), options)
  } else {
    form.post(route('aspirants.store'), options)
  }
}
</script>

<template>
  <Head title="Governorship Aspirant" />
  <AppLayout>
    <div class="space-y-6">
      <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 class="text-lg font-black text-gray-900 sm:text-xl">Aspirant (Governor)</h2>
          <p class="mt-1 text-xs font-medium text-gray-500 sm:text-sm">
            The party's flagship governorship candidate and campaign profile
          </p>
        </div>
        <button
          type="button"
          @click="openEdit"
          class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-green-800 active:bg-green-900 sm:text-sm"
        >
          <Pencil class="h-4 w-4" />
          {{ aspirant ? 'Edit Profile' : 'Set Up Profile' }}
        </button>
      </div>

      <!-- Empty state -->
      <div
        v-if="!aspirant"
        class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-200 bg-white p-12 text-center"
      >
        <img :src="aspirantImage" alt="Governorship aspirant" class="h-24 w-24 rounded-2xl object-cover opacity-60" />
        <p class="mt-4 text-sm font-semibold text-gray-700">No governorship aspirant has been set up yet</p>
        <p class="mt-1 max-w-sm text-xs text-gray-400">
          Register the party's governorship candidate to showcase their campaign profile here.
        </p>
      </div>

      <!-- Profile -->
      <div v-else class="space-y-6">
        <!-- Hero -->
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
          <div class="relative h-40 bg-gradient-to-r from-green-800 to-green-600 sm:h-52">
            <div class="absolute -bottom-12 left-6 sm:left-10">
              <img
                :src="heroImage"
                :alt="fullName"
                class="h-28 w-28 rounded-2xl border-4 border-white object-cover shadow-lg sm:h-36 sm:w-36"
              />
            </div>
          </div>
          <div class="px-6 pb-6 pt-16 sm:px-10 sm:pt-20">
            <h3 class="text-xl font-black text-gray-900 sm:text-2xl">{{ fullName }}</h3>
            <p class="mt-1 text-sm font-semibold text-green-700">
              {{ aspirant.title ?? 'Governorship Candidate' }}
            </p>
            <p v-if="aspirant.constituency" class="mt-1 flex items-center gap-1.5 text-xs text-gray-400">
              <MapPin class="h-3.5 w-3.5" />
              {{ aspirant.constituency }}{{ aspirant.state ? `, ${aspirant.state} State` : '' }}
            </p>
          </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
          <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
              <Users class="h-4 w-4 text-green-600" />
              Total Supporters
            </div>
            <p class="mt-2 text-2xl font-black text-gray-900">{{ aspirant.total_supporters.toLocaleString() }}</p>
          </div>
          <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
              <TrendingUp class="h-4 w-4 text-blue-600" />
              Growth This Week
            </div>
            <p class="mt-2 text-2xl font-black text-gray-900">
              {{ aspirant.supporters_growth_this_week >= 0 ? '+' : '' }}{{ aspirant.supporters_growth_this_week.toLocaleString() }}
            </p>
          </div>
          <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-2 text-xs font-semibold text-gray-400">
              <UserCog class="h-4 w-4 text-purple-600" />
              Campaign Team
            </div>
            <p class="mt-2 text-2xl font-black text-gray-900">{{ aspirant.campaign_team_members.toLocaleString() }}</p>
          </div>
          <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between text-xs font-semibold text-gray-400">
              <span>Overall Progress</span>
              <span class="text-gray-700">{{ aspirant.overall_progress }}%</span>
            </div>
            <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-100">
              <div
                class="h-full rounded-full bg-gradient-to-r from-green-600 to-green-500 transition-all"
                :style="{ width: `${aspirant.overall_progress}%` }"
              />
            </div>
          </div>
        </div>

        <!-- Vision & Mission -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h4 class="text-xs font-bold uppercase tracking-wide text-gray-400">Vision</h4>
            <p class="mt-2 text-sm leading-relaxed text-gray-700">{{ aspirant.vision ?? 'Not yet provided.' }}</p>
          </div>
          <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h4 class="text-xs font-bold uppercase tracking-wide text-gray-400">Mission</h4>
            <p class="mt-2 text-sm leading-relaxed text-gray-700">{{ aspirant.mission ?? 'Not yet provided.' }}</p>
          </div>
        </div>
      </div>
    </div>

    <SlideOver
      :open="modalOpen"
      :title="aspirant ? 'Edit Governorship Profile' : 'Set Up Governorship Profile'"
      description="Update the party's governorship candidate details and campaign profile."
      size="lg"
      side="right"
      @close="closeModal"
    >
      <AspirantForm
        :form="form"
        :submit-label="aspirant ? 'Save changes' : 'Create profile'"
        :password-optional="!!aspirant"
        :lock-office="true"
        :constituencies="formOptions.constituencies"
        :offices="formOptions.offices"
        @submit="submitForm"
        @cancel="closeModal"
      />
    </SlideOver>
  </AppLayout>
</template>