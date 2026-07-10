<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import {
  LayoutDashboard, Users, UserCheck, Briefcase, Handshake, RotateCcw,
  Shield, Vote, Calendar, MapPin, Users2, BarChart3, Activity,
  Megaphone, BookOpen, Baby, DoorClosed, UserCog,
  CreditCard, Receipt, HandCoins, FileText,
  ClipboardList, Bot, TrendingUp, MessageSquare, Star,
  Settings, Key, ScrollText, HardDrive, ChevronRight, Building2, X
} from 'lucide-vue-next'
import logoUrl from '@/assets/logo.jpg'

const props = defineProps<{
  collapsed: boolean
  open?: boolean // mobile drawer visibility
}>()

const emit = defineEmits<{ (e: 'close'): void }>()

const page = usePage()

const navGroups = [
  {
    group: 'People & Structure',
    items: [
      { label: 'Members', route: '/dashboard/members', icon: 'Users' },
      { label: 'Party Agents', route: '/dashboard/party-agents', icon: 'UserCheck' },
      { label: 'Coordinators', route: '/dashboard/coordinators', icon: 'Briefcase' },
      { label: 'Stakeholders', route: '/dashboard/stakeholders', icon: 'Handshake' },
      { label: 'Returning Officers', route: '/dashboard/returning-officers', icon: 'RotateCcw' },
      { label: 'Supervisory Agents', route: '/dashboard/supervisory-agents', icon: 'Shield' },
    ],
  },
  {
    group: 'Election Management',
    items: [
      { label: 'Aspirant (Governor)', route: '/dashboard/aspirant', icon: 'Vote' },
      { label: 'All Aspirants', route: '/dashboard/aspirants', icon: 'Users' },
      { label: 'Election Calendar', route: '/dashboard/election-calendar', icon: 'Calendar' },
      { label: 'Polling Units', route: '/dashboard/polling-units', icon: 'MapPin' },
      { label: 'Campaign Teams', route: '/dashboard/campaign-teams', icon: 'Users2' },
      { label: 'Results Management', route: '/dashboard/results', icon: 'BarChart3' },
    ],
  },
  {
    group: 'Campaign & Activities',
    items: [
      { label: 'Campaign Activities', route: '/campaign-activities', icon: 'Activity' },
      { label: 'Events & Meetings', route: '/events', icon: 'Calendar' },
      { label: 'Mobilization Activities', route: '/mobilization', icon: 'Megaphone' },
      { label: 'Media & Publicity', route: '/media', icon: 'Star' },
      { label: 'Voter Education', route: '/voter-education', icon: 'BookOpen' },
      { label: 'Youth & WomenWing', route: '/youth-women', icon: 'Baby' },
      { label: 'Door to Door Tracking', route: '/door-tracking', icon: 'DoorClosed' },
      { label: 'Volunteers Management', route: '/volunteers', icon: 'UserCog' },
    ],
  },
  {
    group: 'Financial Management',
    items: [
      { label: 'Donations', route: '/donations', icon: 'HandCoins' },
      { label: 'Expenditures', route: '/expenditures', icon: 'Receipt' },
      { label: 'Fundraising', route: '/fundraising', icon: 'CreditCard' },
      { label: 'Financial Reports', route: '/financial-reports', icon: 'FileText' },
    ],
  },
  {
    group: 'Reports & Analytics',
    items: [
      { label: 'Membership Reports', route: '/reports/membership', icon: 'ClipboardList' },
      { label: 'Agent Reports', route: '/reports/agents', icon: 'Bot' },
      { label: 'Election Reports', route: '/reports/election', icon: 'BarChart3' },
      { label: 'Activity Reports', route: '/reports/activity', icon: 'TrendingUp' },
      { label: 'Survey & Feedback', route: '/surveys', icon: 'MessageSquare' },
    ],
  },
  {
    group: 'System',
    items: [
      { label: 'User Management', route: '/users', icon: 'Users' },
      { label: 'Roles & Permissions', route: '/roles', icon: 'Key' },
      { label: 'Settings', route: '/settings', icon: 'Settings' },
      { label: 'Audit Logs', route: '/audit-logs', icon: 'ScrollText' },
      { label: 'Backup & Restore', route: '/backup', icon: 'HardDrive' },
    ],
  },
]

const iconMap: Record<string, any> = {
  Users, UserCheck, Briefcase, Handshake, RotateCcw, Shield,
  Vote, Calendar, MapPin, Users2, BarChart3, Activity,
  Megaphone, BookOpen, Baby, DoorClosed, UserCog, Star,
  CreditCard, Receipt, HandCoins, FileText,
  ClipboardList, Bot, TrendingUp, MessageSquare,
  Settings, Key, ScrollText, HardDrive,
}

function getIcon(name?: string) {
  return name ? iconMap[name] ?? Users : Users
}

function isActive(href: string, exact = false): boolean {
  if (exact) return page.url === href
  return page.url === href || page.url.startsWith(href + '/')
}

// Close the mobile drawer whenever a nav link is tapped (harmless on desktop)
function handleNavClick() {
  emit('close')
}
</script>

<template>
  <!-- Mobile backdrop -->
  <Transition name="fade">
    <div
      v-if="open"
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
      @click="emit('close')"
    />
  </Transition>

  <aside
    :class="[
      'fixed inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 lg:static lg:translate-x-0',
      open ? 'translate-x-0' : '-translate-x-full',
      collapsed ? 'w-60 lg:w-16' : 'w-60',
    ]"
    style="background: linear-gradient(180deg, #0d3b26 0%, #092b1c 40%, #061a11 100%);"
  >
    <!-- Logo -->
    <div
      :class="['flex items-center gap-3 px-4 py-4 border-b', (collapsed && !open) ? 'lg:justify-center' : '']"
      style="border-color: rgba(255,255,255,0.08); background: rgba(0,0,0,0.2);"
    >
      <!-- Pro Logo Mark -->
      <div class="relative flex-shrink-0">
        <div
          class="w-8 h-8 rounded-full flex items-center justify-center"
          style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 50%, #e8c44a 100%); padding: 2px; box-shadow: 0 0 0 2px rgba(232,196,74,0.25), 0 4px 12px rgba(0,0,0,0.4);"
        >
          <div
            class="w-full h-full rounded-full flex items-center justify-center overflow-hidden"
            style="background: linear-gradient(145deg, #0d3b26, #061a11);"
          >
            <img
              v-if="logoUrl"
              :src="logoUrl"
              alt="PRP"
              class="w-full h-full rounded-full object-cover"
            />
            <svg v-else viewBox="0 0 36 36" class="w-7 h-7" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 3 L23 8 L30 8 L30 22 C30 28 18 33 18 33 C18 33 6 28 6 22 L6 8 L13 8 Z"
                fill="none" stroke="#e8c44a" stroke-width="1.2"/>
              <path d="M18 3 L23 8 L13 8 Z" fill="#e8c44a" opacity="0.3"/>
              <text x="18" y="22" text-anchor="middle" font-size="7" font-weight="900"
                font-family="Arial,sans-serif" fill="#e8c44a" letter-spacing="0.5">PRP</text>
              <circle cx="11" cy="13" r="1" fill="#e8c44a"/>
              <circle cx="25" cy="13" r="1" fill="#e8c44a"/>
            </svg>
          </div>
        </div>
        <div
          class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 flex items-center justify-center"
          style="background: #22c55e; border-color: #0d3b26;"
        />
      </div>

      <Transition name="label">
        <div v-if="!collapsed || open" class="overflow-hidden flex-1">
          <p
            class="font-black text-base leading-none tracking-widest"
            style="color: #e8c44a; text-shadow: 0 1px 4px rgba(232,196,74,0.4);"
          >PRP</p>
          <p
            class="font-bold text-[9px] uppercase mt-1 tracking-[0.25em]"
            style="color: rgba(255,255,255,0.55);"
          >Bauchi State</p>
        </div>
      </Transition>

      <!-- Close button (mobile only) -->
      <button
        class="lg:hidden p-1.5 rounded-lg flex-shrink-0"
        style="color: rgba(255,255,255,0.6);"
        aria-label="Close menu"
        @click="emit('close')"
      >
        <X class="w-5 h-5" />
      </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-3 space-y-1 sidebar-scroll">
      <div class="px-2">
        <Link
          href="/dashboard"
          @click="handleNavClick"
          :class="[
            'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-bold transition-all duration-200',
            (collapsed && !open) ? 'lg:justify-center' : '',
          ]"
          :style="isActive('/dashboard', true)
            ? 'background: linear-gradient(90deg,#22c55e,#16a34a); color:#fff; box-shadow: 0 2px 8px rgba(34,197,94,0.35);'
            : 'color: rgba(255,255,255,0.75);'"
          :title="(collapsed && !open) ? 'Dashboard' : undefined"
        >
          <LayoutDashboard class="w-4 h-4 flex-shrink-0" />
          <span v-if="!collapsed || open">Dashboard</span>
        </Link>
      </div>

      <template v-for="group in navGroups" :key="group.group">
        <div class="px-2">
          <p
            v-if="!collapsed || open"
            class="px-3 py-1.5 text-[9px] font-black uppercase tracking-[0.22em]"
            style="color: rgba(255,255,255,0.3);"
          >
            {{ group.group }}
          </p>
          <div
            v-else
            class="mx-2 my-1 border-t"
            style="border-color: rgba(255,255,255,0.08);"
          />

          <ul class="space-y-0.5">
            <li v-for="item in group.items" :key="item.label">
              <Link
                :href="item.route || '#'"
                @click="handleNavClick"
                :class="[
                  'flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold transition-all duration-200 group',
                  (collapsed && !open) ? 'lg:justify-center' : '',
                ]"
                :style="isActive(item.route || '')
                  ? 'background: linear-gradient(90deg,#22c55e,#16a34a); color:#fff; box-shadow: 0 2px 8px rgba(34,197,94,0.35);'
                  : 'color: rgba(255,255,255,0.65);'"
                :title="(collapsed && !open) ? item.label : undefined"
              >
                <component :is="getIcon(item.icon)" class="w-4 h-4 flex-shrink-0" />
                <span v-if="!collapsed || open" class="truncate flex-1">{{ item.label }}</span>
                <ChevronRight
                  v-if="!collapsed || open"
                  class="w-3 h-3 ml-auto flex-shrink-0 opacity-30 group-hover:opacity-60 transition-opacity"
                />
              </Link>
            </li>
          </ul>
        </div>
      </template>
    </nav>

    <!-- Footer -->
    <div
      :class="['p-3 border-t', (collapsed && !open) ? 'lg:flex lg:justify-center' : '']"
      style="border-color: rgba(255,255,255,0.08); background: rgba(0,0,0,0.25);"
    >
      <div :class="['flex items-center gap-3', (collapsed && !open) ? 'lg:justify-center' : 'px-1']">
        <div
          class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
          style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.25);"
        >
          <Building2 class="w-4 h-4" style="color: #4ade80;" />
        </div>
        <div v-if="!collapsed || open" class="overflow-hidden">
          <p class="text-xs font-bold truncate" style="color: rgba(255,255,255,0.85);">Smart Core ICT</p>
          <p class="text-[10px] font-medium" style="color: rgba(255,255,255,0.35);">Service Consultant</p>
        </div>
      </div>
    </div>
  </aside>
</template>

<style scoped>
.label-enter-active,
.label-leave-active {
  transition: opacity 0.2s ease, max-width 0.3s ease;
}
.label-enter-from,
.label-leave-to {
  opacity: 0;
  max-width: 0;
}
.label-enter-to,
.label-leave-from {
  opacity: 1;
  max-width: 200px;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.sidebar-scroll {
  scrollbar-width: thin;
  scrollbar-color: rgba(255,255,255,0.1) transparent;
}
.sidebar-scroll::-webkit-scrollbar {
  width: 3px;
}
.sidebar-scroll::-webkit-scrollbar-thumb {
  background-color: rgba(255,255,255,0.1);
  border-radius: 4px;
}

a:not([style*="linear-gradient"]):hover {
  background: rgba(255,255,255,0.07) !important;
  color: rgba(255,255,255,0.95) !important;
}
</style>