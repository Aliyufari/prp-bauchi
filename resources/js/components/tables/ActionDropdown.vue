<script setup lang="ts">
import { ref, onUnmounted } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { MoreVertical, Eye, Pencil, UserPlus, Ban, Trash2 } from 'lucide-vue-next'

export interface RowAction {
  key: string
  label: string
  icon?: 'eye' | 'edit' | 'assign' | 'suspend' | 'delete'
  danger?: boolean
}

interface Props {
  actions?: RowAction[]
}
const props = withDefaults(defineProps<Props>(), {
  actions: () => [
    { key: 'view', label: 'View details', icon: 'eye' },
    { key: 'edit', label: 'Edit', icon: 'edit' },
    { key: 'assign', label: 'Assign agent', icon: 'assign' },
    { key: 'suspend', label: 'Suspend', icon: 'suspend', danger: true },
    { key: 'delete', label: 'Delete', icon: 'delete', danger: true },
  ],
})

const emit = defineEmits<{ action: [key: string] }>()

const icons = { eye: Eye, edit: Pencil, assign: UserPlus, suspend: Ban, delete: Trash2 }

const open = ref(false)
const root = ref<HTMLElement | null>(null)
const triggerButton = ref<HTMLElement | null>(null)
const menuStyle = ref<Record<string, string>>({})

onClickOutside(root, () => closeMenu(), { ignore: [triggerButton] })

function updatePosition() {
  if (!triggerButton.value) return
  const rect = triggerButton.value.getBoundingClientRect()

  // If the trigger button has scrolled out of view entirely (e.g. table
  // scrolled past it), close the menu rather than leaving it floating
  // somewhere disconnected from any visible row.
  const viewportWidth = window.innerWidth
  const viewportHeight = window.innerHeight
  const outOfView =
    rect.bottom < 0 || rect.top > viewportHeight || rect.right < 0 || rect.left > viewportWidth

  if (outOfView) {
    closeMenu()
    return
  }

  menuStyle.value = {
    position: 'fixed',
    top: `${rect.bottom + 4}px`,
    right: `${viewportWidth - rect.right}px`,
  }
}

function toggle() {
  if (open.value) {
    closeMenu()
    return
  }
  updatePosition()
  open.value = true
  // Capture phase catches scroll from any scrollable ancestor
  // (e.g. the table's horizontal overflow wrapper), not just window.
  window.addEventListener('scroll', updatePosition, true)
  window.addEventListener('resize', updatePosition)
}

function closeMenu() {
  open.value = false
  window.removeEventListener('scroll', updatePosition, true)
  window.removeEventListener('resize', updatePosition)
}

function select(key: string) {
  closeMenu()
  emit('action', key)
}

onUnmounted(() => {
  window.removeEventListener('scroll', updatePosition, true)
  window.removeEventListener('resize', updatePosition)
})
</script>

<template>
  <div ref="root" class="relative inline-block text-left">
    <button
      ref="triggerButton"
      type="button"
      aria-label="Row actions"
      @click="toggle"
      class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
    >
      <MoreVertical class="h-4 w-4" />
    </button>

    <Teleport to="body">
      <Transition
        enter-active-class="transition ease-out duration-100"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="open"
          :style="menuStyle"
          class="z-50 w-44 origin-top-right rounded-xl border border-gray-100 bg-white py-1 shadow-lg"
        >
          <button
            v-for="action in actions"
            :key="action.key"
            type="button"
            @click="select(action.key)"
            class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-medium transition"
            :class="action.danger ? 'text-red-600 hover:bg-red-50' : 'text-gray-700 hover:bg-gray-50'"
          >
            <component :is="icons[action.icon ?? 'eye']" class="h-3.5 w-3.5" />
            {{ action.label }}
          </button>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>