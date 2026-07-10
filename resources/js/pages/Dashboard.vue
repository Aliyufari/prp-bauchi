<script setup lang="ts">
import { ref, computed } from 'vue'
import { Download } from 'lucide-vue-next'

import AppLayout from '@/layouts/AppLayout.vue'
import StatCard from '@/components/dashboard/StatCard.vue'
import MembershipChart from '@/components/dashboard/MembershipChart.vue'
import CampaignActivities from '@/components/dashboard/CampaignActivities.vue'
import GovernorshipAspirant from '@/components/dashboard/GovernorshipAspirant.vue'
import ElectionStrategy from '@/components/dashboard/ElectionStrategy.vue'
import UpcomingActivities from '@/components/dashboard/UpcomingActivities.vue'
import LgaSupportMap from '@/components/dashboard/LgaSupportMap.vue'
import AgentDeployment from '@/components/dashboard/AgentDeployment.vue'
import FinancialSummary from '@/components/dashboard/FinancialSummary.vue'
import Announcements from '@/components/dashboard/Announcements.vue'
import RecentSupporters from '@/components/dashboard/RecentSupporters.vue'

const props = defineProps<{
  stats: {
    totalMembers: number
    totalMembersGrowth: number
    partyAgents: number
    partyAgentsGrowth: number
    coordinators: number
    coordinatorsGrowth: number
    stakeholders: number
    stakeholdersGrowth: number
    upcomingActivities: number
    lgasCovered: number
    totalLgas: number
  }
  membershipByLga: { lga: string; count: number }[]
  campaignActivities: { name: string; percentage: number; color: string }[]
  upcomingActivities: any[]
  electionStrategyActivities: any[]
  lgaSupportData: { lga: string; supportLevel: string }[]
  aspirant: any
  agentDeployment: any
  financialSummary: any
  announcements: any[]
  recentSupporters: any[]
  lgas: string[]
  wards: string[]
  selectedLga: string
  selectedWard: string
}>()

const selectedLga = ref(props.selectedLga ?? '')
const selectedWard = ref(props.selectedWard ?? '')

const currentDateTime = computed(() => {
  return new Date().toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
})
</script>

<template>
  <AppLayout>
    <div class="space-y-6 sm:space-y-8">

      <!-- ================= HEADER ================= -->
      <section class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">

        <div>
          <h2 class="text-lg sm:text-xl font-black text-gray-900">
            Welcome back, Admin
          </h2>
          <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
            {{ currentDateTime }}
          </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">

          <select
            v-model="selectedLga"
            class="text-xs sm:text-sm text-gray-700 border border-gray-200 rounded-xl px-3 py-2 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 flex-1 min-w-[140px] sm:flex-none"
          >
            <option value="">All LGAs</option>
            <option v-for="lga in lgas" :key="lga" :value="lga">
              {{ lga }}
            </option>
          </select>

          <select
            v-model="selectedWard"
            class="text-xs sm:text-sm text-gray-700 border border-gray-200 rounded-xl px-3 py-2 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 flex-1 min-w-[140px] sm:flex-none"
          >
            <option value="">All Wards</option>
            <option v-for="ward in wards" :key="ward" :value="ward">
              {{ ward }}
            </option>
          </select>

          <button
            class="inline-flex items-center justify-center gap-2 bg-green-700 hover:bg-green-800 active:bg-green-900 text-white px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition w-full sm:w-auto"
          >
            <Download class="w-4 h-4" />
            Download Reports
          </button>

        </div>

      </section>

      <!-- ================= STATS ================= -->
      <section>
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">
          <StatCard
            :value="stats.totalMembers"
            label="Total Members"
            icon="Users"
            :growth="stats.totalMembersGrowth"
            icon-bg="bg-green-100"
            icon-color="text-green-700"
          />

          <StatCard
            :value="stats.partyAgents"
            label="Party Agents"
            icon="UserCheck"
            :growth="stats.partyAgentsGrowth"
            icon-bg="bg-blue-100"
            icon-color="text-blue-700"
          />

          <StatCard
            :value="stats.coordinators"
            label="Coordinators"
            icon="Briefcase"
            :growth="stats.coordinatorsGrowth"
            icon-bg="bg-purple-100"
            icon-color="text-purple-700"
          />

          <StatCard
            :value="stats.stakeholders"
            label="Stakeholders"
            icon="Handshake"
            :growth="stats.stakeholdersGrowth"
            icon-bg="bg-amber-100"
            icon-color="text-amber-700"
          />

          <StatCard
            :value="stats.upcomingActivities"
            label="Upcoming Activities"
            icon="Calendar"
            subtitle="This Week"
            icon-bg="bg-red-100"
            icon-color="text-red-600"
          />

          <StatCard
            :value="stats.lgasCovered"
            label="LGAs Covered"
            icon="BarChart3"
            :subtitle="`Out of ${stats.totalLgas} LGAs`"
            icon-bg="bg-teal-100"
            icon-color="text-teal-700"
          />
        </div>
      </section>

      <!-- ================= MAIN ANALYTICS ================= -->
      <section class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">

        <div class="lg:col-span-5">
          <MembershipChart :data="membershipByLga" />
        </div>

        <div class="lg:col-span-4">
          <CampaignActivities
            :activities="campaignActivities"
            :total-activities="120"
          />
        </div>

        <div class="lg:col-span-3">
          <GovernorshipAspirant :aspirant="aspirant" />
        </div>

      </section>

      <!-- ================= SUPPORT INSIGHTS ================= -->
      <section class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">

        <div class="lg:col-span-3">
          <ElectionStrategy :activities="electionStrategyActivities" />
        </div>

        <div class="lg:col-span-3">
          <UpcomingActivities :activities="upcomingActivities" />
        </div>

        <div class="lg:col-span-6">
          <LgaSupportMap :data="lgaSupportData" />
        </div>

      </section>

      <!-- ================= MANAGEMENT ================= -->
      <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">

        <AgentDeployment :deployment="agentDeployment" />
        <FinancialSummary :summary="financialSummary" />
        <Announcements :announcements="announcements" />
        <RecentSupporters :supporters="recentSupporters" />

      </section>

    </div>
  </AppLayout>
</template>