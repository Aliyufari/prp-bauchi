<script setup lang="ts">
import { computed, ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { PanelLeft, Bell, Mail, User, Settings, LogOut } from 'lucide-vue-next'

interface User {
  name: string
  role: string
  avatarUrl?: string
}

const props = defineProps<{ user?: User }>()
defineEmits<{ (e: 'toggle-sidebar'): void }>()

const dropdownOpen = ref(false)

const initials = computed(() => {
  const name = props.user?.name ?? 'Admin'
  return name.split(' ').map((w) => w[0]).slice(0, 2).join('').toUpperCase()
})

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

function closeDropdown() {
  dropdownOpen.value = false
}

function logout() {
  router.post('/logout')
}
</script>

<template>
  <header
    class="bg-white border-b border-gray-100 flex items-center justify-between px-3 sm:px-6 sticky top-0 z-30 shadow-sm h-16"
  >
    <!-- Left: Toggle + Title -->
    <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
      <button
        @click="$emit('toggle-sidebar')"
        class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors flex-shrink-0"
        aria-label="Toggle sidebar"
      >
        <PanelLeft class="w-5 h-5" />
      </button>

      <div class="min-w-0">
        <h1 class="text-green-700 font-black leading-none tracking-tight truncate text-xs xs:text-sm sm:text-base lg:text-lg">
          PRP BAUCHI STATE MANAGEMENT SYSTEM
        </h1>
        <p class="text-red-500 text-[10px] sm:text-xs italic font-semibold mt-0.5 hidden sm:block truncate">
          ...Motto: Justice, Unity and Progress
        </p>
      </div>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-0.5 sm:gap-2 flex-shrink-0 ml-2 sm:ml-3">

      <!-- Notifications -->
      <button
        class="relative p-1.5 sm:p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors"
        aria-label="Notifications"
      >
        <Bell class="w-5 h-5" />
        <span class="absolute top-0.5 right-0.5 min-w-[16px] h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center px-0.5 leading-none">
          8
        </span>
      </button>

      <!-- Messages -->
      <button
        class="relative p-1.5 sm:p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors hidden xs:inline-flex"
        aria-label="Messages"
      >
        <Mail class="w-5 h-5" />
        <span class="absolute top-0.5 right-0.5 min-w-[16px] h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center px-0.5 leading-none">
          15
        </span>
      </button>

      <!-- Divider -->
      <div class="w-px h-7 bg-gray-200 mx-1 hidden sm:block flex-shrink-0" />

      <!-- User profile + dropdown -->
      <div class="relative" v-click-outside="closeDropdown">
        <button
          @click="toggleDropdown"
          class="flex items-center gap-2 pl-1 sm:pl-2 pr-1 sm:pr-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <!-- Avatar -->
          <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg overflow-hidden flex-shrink-0 shadow-sm ring-2 ring-gray-100">
            <img
              v-if="user?.avatarUrl"
              :src="user.avatarUrl"
              :alt="user.name"
              class="w-full h-full object-cover"
            />
            <div
              v-else
              class="w-full h-full flex items-center justify-center"
              style="background: linear-gradient(135deg, #15803d, #14532d);"
            >
              <span class="text-white text-xs font-black">{{ initials }}</span>
            </div>
          </div>

          <!-- Name + role -->
          <div class="text-left hidden md:block">
            <p class="text-sm font-black text-gray-900 leading-none whitespace-nowrap">
              {{ user?.name ?? 'Admin' }}
            </p>
            <p class="text-[11px] text-gray-500 font-semibold mt-0.5 whitespace-nowrap">
              {{ user?.role ?? 'State Chairman' }}
            </p>
          </div>
        </button>

        <!-- Dropdown menu -->
        <Transition name="dropdown">
          <div
            v-if="dropdownOpen"
            class="absolute right-0 mt-2 w-52 max-w-[calc(100vw-1.5rem)] bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
            style="top: 100%;"
          >
            <!-- User info header -->
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
              <p class="text-sm font-black text-gray-900 truncate">{{ user?.name ?? 'Admin' }}</p>
              <p class="text-xs text-gray-500 font-medium truncate mt-0.5">{{ user?.role ?? 'State Chairman' }}</p>
            </div>

            <!-- Menu items -->
            <div class="py-1">
              <Link
                href="/profile"
                @click="closeDropdown"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors font-semibold"
              >
                <User class="w-4 h-4 text-gray-400 flex-shrink-0" />
                My Profile
              </Link>

              <Link
                href="/settings"
                @click="closeDropdown"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors font-semibold"
              >
                <Settings class="w-4 h-4 text-gray-400 flex-shrink-0" />
                Settings
              </Link>
            </div>

            <!-- Logout -->
            <div class="border-t border-gray-100 py-1">
              <button
                @click="logout"
                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors font-bold"
              >
                <LogOut class="w-4 h-4 flex-shrink-0" />
                Log Out
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </div>
  </header>
</template>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transition: opacity 0.15s ease, transform 0.15s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-6px) scale(0.97);
}
.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  transform: translateY(0) scale(1);
}
</style>