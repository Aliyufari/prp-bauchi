<script setup lang="ts">
import { X } from 'lucide-vue-next'

interface BulkAction {
  key: string
  label: string
  danger?: boolean
}

interface Props {
  selected: (string | number)[]
  actions?: BulkAction[]
}
withDefaults(defineProps<Props>(), {
  actions: () => [
    { key: 'export', label: 'Export selected' },
    { key: 'assign', label: 'Assign agent' },
    { key: 'suspend', label: 'Suspend', danger: true },
    { key: 'delete', label: 'Delete', danger: true },
  ],
})

const emit = defineEmits<{ clear: []; action: [key: string] }>()
</script>

<template>
  <Transition
    enter-active-class="transition ease-out duration-150"
    enter-from-class="opacity-0 -translate-y-1"
    enter-to-class="opacity-100 translate-y-0"
    leave-active-class="transition ease-in duration-100"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="selected.length"
      class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-green-100 bg-green-50 px-4 py-3"
    >
      <div class="flex items-center gap-2 text-xs font-semibold text-green-800">
        <button
          type="button"
          @click="emit('clear')"
          class="rounded-full p-1 hover:bg-green-100"
          aria-label="Clear selection"
        >
          <X class="h-3.5 w-3.5" />
        </button>
        {{ selected.length }} selected
      </div>

      <div class="flex flex-wrap items-center gap-2">
        <button
          v-for="action in actions"
          :key="action.key"
          type="button"
          @click="emit('action', action.key)"
          class="rounded-lg px-3 py-1.5 text-xs font-semibold transition"
          :class="
            action.danger
              ? 'bg-white text-red-600 hover:bg-red-50'
              : 'bg-white text-green-800 hover:bg-green-100'
          "
        >
          {{ action.label }}
        </button>
      </div>
    </div>
  </Transition>
</template>