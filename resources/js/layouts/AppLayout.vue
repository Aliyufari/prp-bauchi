<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from '@/components/dashboard/Sidebar.vue'
import Topbar from '@/components/dashboard/Topbar.vue'

const user = { name: 'Admin', role: 'State Chairman' }

const sidebarCollapsed = ref(false) // desktop collapse (lg+)
const mobileSidebarOpen = ref(false) // mobile drawer (< lg)

function toggleSidebar() {
  if (window.innerWidth >= 1024) {
    sidebarCollapsed.value = !sidebarCollapsed.value
  } else {
    mobileSidebarOpen.value = !mobileSidebarOpen.value
  }
}
</script>

<template>
  <div class="min-h-screen bg-green-50 flex">
    <!-- Sidebar -->
    <Sidebar
      :collapsed="sidebarCollapsed"
      :open="mobileSidebarOpen"
      @close="mobileSidebarOpen = false"
    />

    <!-- MAIN WRAPPER -->
    <div class="flex-1 flex flex-col min-h-screen w-full transition-all duration-300">
      <!-- Topbar -->
      <Topbar :user="user" @toggle-sidebar="toggleSidebar" />

      <!-- CONTENT -->
      <main class="flex-1 p-3 sm:p-5 lg:p-6 space-y-6 sm:space-y-8 overflow-x-hidden w-full">
        <slot />
      </main>

      <!-- FOOTER -->
      <footer class="border-t border-gray-100 py-4 px-4 sm:px-6 text-center text-[11px] sm:text-xs text-gray-400 bg-white">
        © {{ new Date().getFullYear() }} PRP Bauchi State Management System |
        Powered by
        <span class="text-green-700 font-bold">Smart Core ICT Service Consultant</span>
      </footer>
    </div>
  </div>
</template>