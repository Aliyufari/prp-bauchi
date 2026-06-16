<script setup lang="ts">
import { TrendingUp } from 'lucide-vue-next'

defineProps<{
  summary: {
    totalDonations: number
    donationsGrowth: number
    totalExpenditures: number
    expendituresGrowth: number
    balance: number
    balanceGrowth: number
  }
}>()

const fmt = (n: number) =>
  '₦' + (n >= 1_000_000
    ? (n / 1_000_000).toFixed(1) + 'M'
    : n >= 1_000
    ? (n / 1_000).toFixed(0) + 'K'
    : n.toString())
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col gap-3">
    <div>
      <h3 class="text-xs font-black uppercase tracking-wider text-gray-800">Fundraising & Financial Summary</h3>
      <p class="text-[10px] text-gray-400 mt-0.5 font-medium">Campaign financial overview</p>
    </div>

    <!-- 3 stat blocks -->
    <div class="grid grid-cols-1 gap-2">
      <!-- Donations -->
      <div class="bg-green-50 rounded-lg p-2.5">
        <p class="text-[9px] font-bold text-green-700 uppercase tracking-wider">Total Donations</p>
        <p class="text-base font-black text-green-900 mt-0.5">{{ fmt(summary.totalDonations) }}</p>
        <div class="flex items-center gap-1 mt-0.5">
          <TrendingUp class="w-3 h-3 text-green-600" />
          <span class="text-[9px] font-bold text-green-600">+{{ summary.donationsGrowth }}%</span>
        </div>
      </div>

      <!-- Expenditures -->
      <div class="bg-red-50 rounded-lg p-2.5">
        <p class="text-[9px] font-bold text-red-600 uppercase tracking-wider">Total Expenditures</p>
        <p class="text-base font-black text-red-900 mt-0.5">{{ fmt(summary.totalExpenditures) }}</p>
        <div class="flex items-center gap-1 mt-0.5">
          <TrendingUp class="w-3 h-3 text-red-500" />
          <span class="text-[9px] font-bold text-red-500">+{{ summary.expendituresGrowth }}%</span>
        </div>
      </div>

      <!-- Balance -->
      <div class="bg-blue-50 rounded-lg p-2.5">
        <p class="text-[9px] font-bold text-blue-700 uppercase tracking-wider">Balance</p>
        <p class="text-base font-black text-blue-900 mt-0.5">{{ fmt(summary.balance) }}</p>
        <div class="flex items-center gap-1 mt-0.5">
          <TrendingUp class="w-3 h-3 text-blue-600" />
          <span class="text-[9px] font-bold text-blue-600">+{{ summary.balanceGrowth }}%</span>
        </div>
      </div>
    </div>

    <button class="w-full text-[10px] font-bold text-green-700 hover:text-green-800 text-center py-1.5 border border-green-100 hover:border-green-200 rounded-lg transition-colors">
      View Financial Report →
    </button>
  </div>
</template>