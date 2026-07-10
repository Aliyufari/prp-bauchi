<script setup lang="ts">
import type { LocationOption } from '@/types/member'
import type { PartyAgentTypeOption } from '@/types/party-agent'

interface FormShape {
  first_name: string
  middle_name: string | null
  last_name: string
  email: string
  password?: string
  phone: string | null

  gender: string | null
  occupation: string | null
  education_status: string | null

  application_id: string | null
  type: string | null

  state_id: number | string | null
  zone_id: number | string | null
  lga_id: number | string | null
  ward_id: number | string | null
  pu_id: number | string | null

  errors: Record<string, string>
  processing: boolean
}

interface Props {
  form: FormShape
  submitLabel?: string
  passwordOptional?: boolean
  states?: LocationOption[]
  zones?: LocationOption[]
  lgas?: LocationOption[]
  wards?: LocationOption[]
  pus?: LocationOption[]
  types?: PartyAgentTypeOption[]
}
withDefaults(defineProps<Props>(), {
  submitLabel: 'Save',
  passwordOptional: false,
  states: () => [],
  zones: () => [],
  lgas: () => [],
  wards: () => [],
  pus: () => [],
  types: () => [],
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
          <p v-if="form.errors.phone" class="mt-1 text-xs text-red-600">{{ form.errors.phone }}</p>
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
          <label class="mb-1 block text-xs font-medium text-gray-600">Agent ID</label>
          <input
            v-model="form.application_id"
            type="text"
            placeholder="Auto-generated if left blank"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
      </div>
    </fieldset>

    <!-- Agent details -->
    <fieldset class="space-y-4">
      <legend class="text-xs font-bold uppercase tracking-wide text-gray-400">Agent details</legend>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Agent type</label>
          <select
            v-model="form.type"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option value="" disabled>Select type</option>
            <option v-for="t in types" :key="t.value" :value="t.value">{{ t.label }}</option>
          </select>
          <p v-if="form.errors.type" class="mt-1 text-xs text-red-600">{{ form.errors.type }}</p>
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

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Occupation</label>
          <input
            v-model="form.occupation"
            type="text"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
      </div>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Education status</label>
          <input
            v-model="form.education_status"
            type="text"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>
      </div>
    </fieldset>

    <!-- Deployment -->
    <fieldset class="space-y-4">
      <legend class="text-xs font-bold uppercase tracking-wide text-gray-400">Deployment</legend>

      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">State</label>
          <select
            v-model="form.state_id"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Select state</option>
            <option v-for="s in states" :key="s.id" :value="s.id">{{ s.name }}</option>
          </select>
          <p v-if="form.errors.state_id" class="mt-1 text-xs text-red-600">{{ form.errors.state_id }}</p>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Zone</label>
          <select
            v-model="form.zone_id"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Select zone</option>
            <option v-for="z in zones" :key="z.id" :value="z.id">{{ z.name }}</option>
          </select>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">LGA</label>
          <select
            v-model="form.lga_id"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Select LGA</option>
            <option v-for="l in lgas" :key="l.id" :value="l.id">{{ l.name }}</option>
          </select>
          <p v-if="form.errors.lga_id" class="mt-1 text-xs text-red-600">{{ form.errors.lga_id }}</p>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Ward</label>
          <select
            v-model="form.ward_id"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Select ward</option>
            <option v-for="w in wards" :key="w.id" :value="w.id">{{ w.name }}</option>
          </select>
        </div>

        <div>
          <label class="mb-1 block text-xs font-medium text-gray-600">Polling unit</label>
          <select
            v-model="form.pu_id"
            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
          >
            <option :value="null" disabled>Not yet assigned</option>
            <option v-for="p in pus" :key="p.id" :value="p.id">{{ p.name }}</option>
          </select>
        </div>
      </div>

      <p class="text-xs text-gray-400">
        Leaving Polling unit unset marks this agent as "Unassigned" on the dashboard until deployed.
      </p>
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