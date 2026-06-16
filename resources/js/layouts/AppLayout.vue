<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <Sidebar :collapsed="sidebarCollapsed" />

    <!-- Main content wrapper -->
    <div
      :class="[
        'flex-1 flex flex-col min-h-screen transition-all duration-300',
        sidebarCollapsed ? 'ml-16' : 'ml-56',
      ]"
    >
      <!-- Top Bar -->
      <TopBar :user="$page.props.auth?.user" @toggle-sidebar="sidebarCollapsed = !sidebarCollapsed" />

      <!-- Page content -->
      <main class="flex-1 overflow-auto">
        <slot />
      </main>

      <!-- Footer -->
      <footer class="bg-white border-t border-gray-200 py-3 px-6 text-center">
        <p class="text-xs text-gray-400">
          © 2024 PRP Bauchi State Management System. All Rights Reserved. | Powered by
          <a href="#" class="text-green-700 font-semibold hover:underline">Smart Core ICT Service Consultant</a>
        </p>
      </footer>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from '@/components/dashboard/Sidebar.vue'
import TopBar from '@/components/dashboard/Topbar.vue'

const sidebarCollapsed = ref(false)
</script>
