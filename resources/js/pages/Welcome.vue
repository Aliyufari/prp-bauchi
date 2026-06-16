<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import banner from '@/assets/elections.jpg';
import logoUrl from '@/assets/logo.jpg';
import { ArrowRight, ShieldCheck, Users, BarChart3, MapPin } from 'lucide-vue-next';
</script>

<template>
  <Head title="Welcome – PRP Bauchi State" />

  <div class="min-h-screen flex flex-col relative bg-[#061a11] overflow-hidden">
    
    <!-- Premium Background Layer -->
    <div 
      class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30"
      :style="{ backgroundImage: `url(${banner})` }"
    />
    
    <!-- Dynamic Gradient Overlay -->
    <div 
      class="absolute inset-0 z-0" 
      style="background: linear-gradient(135deg, rgba(13, 59, 38, 0.95) 0%, rgba(6, 26, 17, 0.85) 100%);"
    />

    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-1/3 h-full bg-[#dc2626]/5 skew-x-12 translate-x-20 z-0" />

    <!-- Content wrapper -->
    <div class="relative z-10 flex flex-col min-h-screen">
      
      <!-- Navbar -->
      <header class="w-full px-6 lg:px-12 py-6 flex justify-between items-center border-b border-white/10 backdrop-blur-md">
        <div class="flex items-center gap-3">
          <div class="relative flex-shrink-0">
              <div
                  class="w-10 h-10 rounded-full flex items-center justify-center"
                  style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 50%, #e8c44a 100%); padding: 1.5px;"
              >
                  <div class="w-full h-full rounded-full flex items-center justify-center overflow-hidden bg-[#0d3b26]">
                      <img v-if="logoUrl" :src="logoUrl" alt="PRP" class="w-full h-full object-cover" />
                      <ShieldCheck v-else class="w-5 h-5 text-[#e8c44a]" />
                  </div>
              </div>
          </div>
          <div class="hidden sm:block">
              <p class="font-black text-lg tracking-widest leading-none text-white">PRP</p>
              <p class="font-bold text-[9px] uppercase tracking-[0.2em] text-[#e8c44a]">Bauchi State</p>
          </div>
        </div>

        <nav class="flex items-center gap-2 sm:gap-6">
          <template v-if="$page.props.auth.user">
            <Link
              :href="route('dashboard')"
              class="px-5 py-2.5 rounded-lg text-sm font-bold text-white transition-all"
              style="background: linear-gradient(90deg, #22c55e, #16a34a); box-shadow: 0 4px 12px rgba(22,163,74,0.3);"
            >
              Access Dashboard
            </Link>
          </template>
          <template v-else>
            <Link
              :href="route('login')"
              class="text-sm font-bold text-white hover:text-[#e8c44a] transition-colors"
            >
              Sign In
            </Link>
            <Link
              :href="route('register')"
              class="px-5 py-2.5 rounded-lg text-sm font-bold text-[#0d3b26] transition-all hover:scale-105"
              style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 100%);"
            >
              Request Access
            </Link>
          </template>
        </nav>
      </header>

      <!-- Hero Section -->
      <main class="flex-1 flex flex-col items-center justify-center text-center px-6 py-16 lg:py-24">
        
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-[#e8c44a]/30 bg-[#e8c44a]/10 mb-8 animate-fade-in">
          <span class="w-2 h-2 rounded-full bg-[#e8c44a] animate-pulse"></span>
          <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e8c44a]">Official State Portal 2026</span>
        </div>

        <h2 class="text-4xl md:text-6xl lg:text-7xl font-black tracking-tight text-white leading-[1.1]">
          Justice, Unity <br class="hidden md:block" /> 
          <span style="color: #4ade80; text-shadow: 0 0 30px rgba(74,222,128,0.2);">Progress for Bauchi</span>
        </h2>
        
        <p class="mt-8 max-w-2xl text-base md:text-lg text-white/70 leading-relaxed font-medium">
          The centralized digital command center for the People's Redemption Party. 
          Streamlining member registration, election monitoring, and grassroots mobilization across all 20 LGAs.
        </p>

        <div class="mt-12 flex flex-col sm:flex-row gap-4 w-full max-w-md justify-center">
          <Link
            v-if="!$page.props.auth.user"
            :href="route('register')"
            class="group px-8 py-4 text-sm font-black rounded-xl text-[#0d3b26] transition-all flex items-center justify-center gap-2"
            style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 100%); box-shadow: 0 10px 20px rgba(0,0,0,0.2);"
          >
            JOIN THE MOVEMENT
            <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
          </Link>
          
          <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="px-8 py-4 text-sm font-black rounded-xl text-white transition-all flex items-center justify-center gap-2"
            style="background: linear-gradient(90deg, #22c55e, #16a34a);"
          >
            GO TO DASHBOARD
            <ArrowRight class="w-4 h-4" />
          </Link>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20 max-w-5xl w-full">
          <div v-for="feature in [
            { icon: Users, title: 'Member Mgmt', desc: 'Secure database of state-wide party faithfuls.' },
            { icon: MapPin, title: 'LGA Coverage', desc: 'Real-time reporting from all 20 local governments.' },
            { icon: BarChart3, title: 'Data Integrity', desc: 'Transparent election recording and verification.' }
          ]" :key="feature.title" class="p-6 rounded-2xl bg-white/5 border border-white/10 text-left hover:bg-white/10 transition-colors group">
            <component :is="feature.icon" class="w-8 h-8 text-[#e8c44a] mb-4 group-hover:scale-110 transition-transform" />
            <h3 class="text-white font-bold text-lg">{{ feature.title }}</h3>
            <p class="text-white/50 text-sm mt-2">{{ feature.desc }}</p>
          </div>
        </div>
      </main>

      <!-- Footer -->
      <footer class="py-8 px-12 flex flex-col md:flex-row justify-between items-center gap-4 border-t border-white/5 bg-black/20 backdrop-blur-lg">
        <p class="text-[11px] text-white/40 uppercase tracking-widest font-medium">
          © 2026 PRP Bauchi State · <span class="text-[#e8c44a]">Smart Core ICT Service</span>
        </p>
        <div class="flex gap-8">
          <a href="#" class="text-[10px] font-bold text-white/30 hover:text-[#e8c44a] uppercase tracking-widest transition-colors">Privacy Policy</a>
          <a href="#" class="text-[10px] font-bold text-white/30 hover:text-[#e8c44a] uppercase tracking-widest transition-colors">Terms of Service</a>
        </div>
      </footer>
    </div>
  </div>
</template>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.8s ease-out forwards;
}
</style>