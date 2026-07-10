<script setup lang="ts">
import { onMounted, onUnmounted, watch } from 'vue'
interface Props {
  open?: boolean
  title?: string
  description?: string
  size?: 'sm' | 'md' | 'lg' | 'xl'
  side?: 'left' | 'right'
}
const props = withDefaults(defineProps<Props>(), {
  open: true,
  size: 'md',
  side: 'right',
})
const emit = defineEmits<{ close: [] }>()

// Full width on mobile (no cap), capped from sm: upward.
const sizes: Record<string, string> = {
  sm: 'sm:max-w-md',
  md: 'sm:max-w-xl',
  lg: 'sm:max-w-2xl',
  xl: 'sm:max-w-3xl',
}

function onKeydown(e: KeyboardEvent) {
  if (e.key === 'Escape') emit('close')
}
function lockScroll(locked: boolean) {
  document.documentElement.style.overflow = locked ? 'hidden' : ''
}
onMounted(() => {
  document.addEventListener('keydown', onKeydown)
  if (props.open) lockScroll(true)
})
onUnmounted(() => {
  document.removeEventListener('keydown', onKeydown)
  lockScroll(false)
})
watch(
  () => props.open,
  (val) => lockScroll(val),
)
</script>

<template>
  <Teleport to="body">
    <Transition name="panel-fade">
      <div v-if="open" class="fixed inset-0 z-50">
        <!-- Backdrop -->
        <div
          class="absolute inset-0 bg-gray-900/40 backdrop-blur-[2px]"
          @click="emit('close')"
        />
        <!-- Panel wrapper -->
        <div
          class="absolute inset-y-0 flex w-full"
          :class="side === 'right' ? 'right-0 justify-end' : 'left-0 justify-start'"
        >
          <Transition :name="side === 'right' ? 'slide-right' : 'slide-left'" appear>
            <div
              v-if="open"
              class="flex h-full w-full flex-col bg-white shadow-2xl sm:h-full"
              :class="sizes[size]"
            >
              <!-- Header -->
              <div
                class="flex items-start justify-between gap-3 border-b border-gray-100 px-4 py-4 sm:gap-4 sm:px-6 sm:py-5"
              >
                <div class="min-w-0">
                  <h2 class="truncate text-sm font-bold text-gray-900 sm:text-base">
                    {{ title }}
                  </h2>
                  <p
                    v-if="description"
                    class="mt-0.5 line-clamp-2 text-xs text-gray-500 sm:line-clamp-none"
                  >
                    {{ description }}
                  </p>
                </div>
                <button
                  type="button"
                  aria-label="Close panel"
                  @click="emit('close')"
                  class="shrink-0 rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 active:bg-gray-200"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
              </div>

              <!-- Body -->
              <div class="flex-1 overflow-y-auto px-4 py-4 sm:px-6 sm:py-5">
                <slot />
              </div>

              <!-- Footer -->
              <div
                v-if="$slots.footer"
                class="border-t border-gray-100 px-4 py-3 sm:px-6 sm:py-4"
              >
                <slot name="footer" />
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.panel-fade-enter-active,
.panel-fade-leave-active {
  transition: opacity 0.2s ease;
}
.panel-fade-enter-from,
.panel-fade-leave-to {
  opacity: 0;
}
.slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active {
  transition: transform 0.28s cubic-bezier(0.32, 0.72, 0, 1);
}
.slide-right-enter-from,
.slide-right-leave-to {
  transform: translateX(100%);
}
.slide-left-enter-from,
.slide-left-leave-to {
  transform: translateX(-100%);
}
</style>