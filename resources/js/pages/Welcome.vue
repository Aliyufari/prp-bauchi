<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import banner from '@/assets/elections.jpg';
import logoUrl from '@/assets/logo.jpg';
import aspirantImage from '@/assets/images/governor-aspirant.jpeg';
import { ArrowRight, ShieldCheck, Users, BarChart3, MapPin, Quote } from 'lucide-vue-next';

const features = [
  { icon: Users, title: 'Member Mgmt', desc: 'Secure database of state-wide party faithfuls.' },
  { icon: MapPin, title: 'LGA Coverage', desc: 'Real-time reporting from all 20 local governments.' },
  { icon: BarChart3, title: 'Data Integrity', desc: 'Transparent election recording and verification.' },
];
</script>

<template>
  <Head title="Welcome – PRP Bauchi State" />

  <div class="min-h-screen flex flex-col relative bg-[#061a11] overflow-hidden">

    <div
      class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-20"
      :style="{ backgroundImage: `url(${banner})` }"
    ></div>

    <div
      class="absolute inset-0 z-0"
      style="background: linear-gradient(135deg, rgba(13, 59, 38, 0.96) 0%, rgba(6, 26, 17, 0.92) 100%);"
    ></div>

    <div class="absolute top-0 right-0 w-1/3 h-full bg-[#dc2626]/5 skew-x-12 translate-x-20 z-0"></div>

    <div class="relative z-10 flex flex-col min-h-screen">

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
            <Link :href="route('login')" class="text-sm font-bold text-white hover:text-[#e8c44a] transition-colors">
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

      <main class="flex-1 flex flex-col">

        <section class="flex-1 grid lg:grid-cols-2 gap-12 items-center px-6 lg:px-12 py-16 lg:py-20 max-w-7xl mx-auto w-full">

          <div class="text-left animate-fade-in">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-[#e8c44a]/30 bg-[#e8c44a]/10 mb-8">
              <span class="w-2 h-2 rounded-full bg-[#e8c44a] animate-pulse"></span>
              <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#e8c44a]">Official State Portal 2026</span>
            </div>

            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.1]">
              Justice, Unity <br />
              <span style="color: #4ade80; text-shadow: 0 0 30px rgba(74,222,128,0.2);">Progress for Bauchi</span>
            </h2>

            <p class="mt-6 max-w-xl text-base md:text-lg text-white/70 leading-relaxed font-medium">
              The centralized digital command center for the People's Redemption Party —
              streamlining member registration, election monitoring, and grassroots
              mobilization across all 20 LGAs.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-4 w-full max-w-md">
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

              <a href="#leadership" class="px-8 py-4 text-sm font-black rounded-xl text-white border border-white/20 hover:border-[#e8c44a]/50 hover:bg-white/5 transition-all flex items-center justify-center gap-2">
                MEET OUR ASPIRANT
              </a>
            </div>

            <div class="mt-14 grid grid-cols-3 gap-6 max-w-md border-t border-white/10 pt-8">
              <div>
                <p class="text-2xl md:text-3xl font-black text-[#e8c44a]">20</p>
                <p class="text-[10px] uppercase tracking-widest text-white/50 font-bold mt-1">LGAs Covered</p>
              </div>
              <div>
                <p class="text-2xl md:text-3xl font-black text-[#e8c44a]">100%</p>
                <p class="text-[10px] uppercase tracking-widest text-white/50 font-bold mt-1">Verified Data</p>
              </div>
              <div>
                <p class="text-2xl md:text-3xl font-black text-[#e8c44a]">24/7</p>
                <p class="text-[10px] uppercase tracking-widest text-white/50 font-bold mt-1">Live Monitoring</p>
              </div>
            </div>
          </div>

          <div class="relative flex justify-center lg:justify-end animate-fade-in">
            <div
              class="absolute -inset-4 rounded-[2rem] opacity-40 blur-2xl"
              style="background: radial-gradient(circle, rgba(232,196,74,0.35), transparent 70%);"
            ></div>
            <div class="relative w-full max-w-md rounded-[1.75rem] overflow-hidden border border-[#e8c44a]/30" style="box-shadow: 0 25px 60px rgba(0,0,0,0.45);">
              <img :src="aspirantImage" alt="PRP Governorship Aspirant" class="w-full h-full object-cover" />
              <div class="absolute inset-x-0 bottom-0 p-6" style="background: linear-gradient(0deg, rgba(6,26,17,0.95) 10%, transparent 100%);">
                <p class="text-[10px] uppercase tracking-[0.2em] text-[#e8c44a] font-black">Governorship Aspirant</p>
                <p class="text-white font-bold text-lg mt-1">Leading Bauchi Forward</p>
              </div>
            </div>
          </div>

        </section>

        <section id="leadership" class="px-6 lg:px-12 py-16 lg:py-20 border-t border-white/5">
          <div class="max-w-4xl mx-auto text-center">
            <Quote class="w-8 h-8 text-[#e8c44a]/50 mx-auto mb-6" />
            <p class="text-xl md:text-2xl font-bold text-white leading-relaxed">
              "Our commitment is to a Bauchi State built on justice, transparency,
              and grassroots progress — powered by the people, for the people."
            </p>
            <p class="mt-6 text-[11px] uppercase tracking-[0.2em] text-[#e8c44a] font-black">
              PRP Governorship Aspirant · Bauchi State 2026
            </p>
          </div>
        </section>

        <section class="px-6 lg:px-12 pb-20">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto w-full">
            <div
              v-for="feature in features"
              :key="feature.title"
              class="p-6 rounded-2xl bg-white/5 border border-white/10 text-left hover:bg-white/10 transition-colors group"
            >
              <component :is="feature.icon" class="w-8 h-8 text-[#e8c44a] mb-4 group-hover:scale-110 transition-transform" />
              <h3 class="text-white font-bold text-lg">{{ feature.title }}</h3>
              <p class="text-white/50 text-sm mt-2">{{ feature.desc }}</p>
            </div>
          </div>
        </section>

      </main>

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