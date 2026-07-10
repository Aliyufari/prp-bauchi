<script setup lang="ts">
import type { AspirantOfficeOption, ConstituencyOption } from '@/types/aspirant'

interface FormShape {
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  password?: string
  phone: string | null

  gender: string | null
  education_status: string | null

  office: string | null
  constituency_id: string | null
  title: string | null
  vision: string | null
  mission: string | null
  image_url: string | null

  overall_progress: number
  total_supporters: number
  supporters_growth_this_week: number
  campaign_team_members: number

  errors: Record<string, string>
  processing: boolean
}

interface Props {
  form: FormShape
  submitLabel?: string
  passwordOptional?: boolean
  lockOffice?: boolean
  constituencies?: ConstituencyOption[]
  offices?: AspirantOfficeOption[]
}
withDefaults(defineProps<Props>(), {
  submitLabel: 'Save',
  passwordOptional: false,
  lockOffice: false,
  constituencies: () => [],
  offices: () => [],
})

const emit = defineEmits<{ submit: []; cancel: [] }>()
</script>

<template>
  <form @submit.prevent="emit('submit')" class="space-y-6">
    <!-- Personal information -->
    <fieldset class="space-y-4">
      <legend class="text-xs font-bold uppercase tracking-wide text-gray-400">
        Personal information
      </legend>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">First name</label>
          <input
            v-model="form.first_name"
            type="text"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <p v-if="form.errors.first_name" class="mt-1 text-xs text-red-600">{{ form.errors.first_name }}</p>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Middle name</label>
          <input
            v-model="form.middle_name"
            type="text"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Last name</label>
          <input
            v-model="form.last_name"
            type="text"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <p v-if="form.errors.last_name" class="mt-1 text-xs text-red-600">{{ form.errors.last_name }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <p v-if="form.errors.email" class="mt-1 text-xs text-red-600">{{ form.errors.email }}</p>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Phone</label>
          <input
            v-model="form.phone"
            type="tel"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
      </div>

      <div v-if="'password' in form" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">
            Password
            <span v-if="passwordOptional" class="font-normal text-gray-400">(leave blank to keep current)</span>
          </label>
          <input
            v-model="form.password"
            type="password"
            autocomplete="new-password"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
          <p v-if="form.errors.password" class="mt-1 text-xs text-red-600">{{ form.errors.password }}</p>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Gender</label>
          <select
            v-model="form.gender"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Select gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
      </div>
    </fieldset>

    <!-- Candidacy -->
    <fieldset class="space-y-4">
      <legend class="text-xs font-bold uppercase tracking-wide text-gray-400">Candidacy</legend>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Office</label>
          <select
            v-model="form.office"
            :disabled="lockOffice"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 disabled:bg-gray-50 disabled:text-gray-400"
          >
            <option value="" disabled>Select office</option>
            <option v-for="o in offices" :key="o.value" :value="o.value">{{ o.label }}</option>
          </select>
          <p v-if="form.errors.office" class="mt-1 text-xs text-red-600">{{ form.errors.office }}</p>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Constituency</label>
          <select
            v-model="form.constituency_id"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Select constituency</option>
            <option v-for="c in constituencies" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
          <p v-if="form.errors.constituency_id" class="mt-1 text-xs text-red-600">{{ form.errors.constituency_id }}</p>
        </div>
      </div>

      <div>
        <label class="mb-1 block text-xs font-medium text-gray-600">Title</label>
        <input
          v-model="form.title"
          type="text"
          placeholder="e.g. Governorship Candidate, Bauchi State"
          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        />
      </div>

      <div>
        <label class="mb-1 block text-xs font-medium text-gray-600">Photo URL</label>
        <input
          v-model="form.image_url"
          type="text"
          placeholder="https://... (leave blank to use default image)"
          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        />
      </div>
    </fieldset>

    <!-- Campaign profile — only meaningful for the governorship candidate -->
    <fieldset v-if="form.office === 'governor'" class="space-y-4">
      <legend class="text-xs font-bold uppercase tracking-wide text-gray-400">Campaign profile</legend>

      <div>
        <label class="mb-1 block text-xs font-medium text-gray-600">Vision</label>
        <textarea
          v-model="form.vision"
          rows="3"
          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        />
      </div>

      <div>
        <label class="mb-1 block text-xs font-medium text-gray-600">Mission</label>
        <textarea
          v-model="form.mission"
          rows="3"
          class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        />
      </div>

      <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Progress (%)</label>
          <input
            v-model.number="form.overall_progress"
            type="number"
            min="0"
            max="100"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Supporters</label>
          <input
            v-model.number="form.total_supporters"
            type="number"
            min="0"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Growth this week</label>
          <input
            v-model.number="form.supporters_growth_this_week"
            type="number"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Team members</label>
          <input
            v-model.number="form.campaign_team_members"
            type="number"
            min="0"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
      </div>
    </fieldset>

    <div class="flex items-center justify-end gap-3 pt-2">
      <button
        type="button"
        @click="emit('cancel')"
        class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-500 transition hover:bg-gray-100"
      >
        Cancel
      </button>
      <button
        type="submit"
        :disabled="form.processing"
        class="rounded-xl bg-green-700 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800 active:bg-green-900 disabled:cursor-not-allowed disabled:opacity-60"
      >
        {{ form.processing ? 'Saving…' : submitLabel }}
      </button>
    </div>
  </form>
</template>