<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3'
import { LoaderCircle, Eye, EyeOff, Lock, Mail, ShieldCheck } from 'lucide-vue-next'
import { ref } from 'vue'
import logoUrl from '@/assets/logo.jpg'

defineProps<{
    status?: string
    canResetPassword: boolean
}>()

const showPassword = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <Head title="Sign In – PRP Bauchi State" />

    <div class="min-h-screen bg-[#f0fdf4] flex">

        <!-- ── Left panel: brand / illustration ── -->
        <div class="hidden lg:flex lg:w-[52%] flex-col relative overflow-hidden" style="background: linear-gradient(180deg, #0d3b26 0%, #092b1c 40%, #061a11 100%);">

            <!-- Geometric accent rings -->
            <div class="absolute -top-32 -left-32 w-[420px] h-[420px] rounded-full border border-white/10" />
            <div class="absolute -top-20 -left-20 w-[300px] h-[300px] rounded-full border border-white/8" />
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full border border-white/6 translate-x-1/3 translate-y-1/3" />

            <!-- Red diagonal stripe — the signature element -->
            <div
                class="absolute top-0 right-0 w-28 h-full bg-[#dc2626]/10 origin-top-right"
                style="clip-path: polygon(100% 0, 100% 100%, 60% 100%, 20% 0)"
            />

            <!-- Content -->
            <div class="relative z-10 flex flex-col h-full px-12 py-10">

                <!-- Brand Logo Component Integration -->
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <!-- Outer ring -->
                        <div
                            class="w-11 h-11 rounded-full flex items-center justify-center"
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
                                <!-- Fallback SVG emblem if no logo -->
                                <svg v-else viewBox="0 0 36 36" class="w-9 h-9" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <!-- Small badge dot -->
                        <div
                            class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 flex items-center justify-center"
                            style="background: #22c55e; border-color: #0d3b26;"
                        />
                    </div>
                    <div>
                        <p class="font-black text-xl tracking-widest leading-none" style="color: #e8c44a; text-shadow: 0 1px 4px rgba(232,196,74,0.4);">PRP</p>
                        <p class="font-bold text-[10px] uppercase mt-1 tracking-[0.25em]" style="color: rgba(255,255,255,0.55);">Bauchi State</p>
                    </div>
                </div>

                <!-- Hero text -->
                <div class="mt-auto mb-auto pt-20">
                    <div class="inline-block border rounded-full px-3 py-1 mb-6" style="background: rgba(232,196,74,0.1); border-color: rgba(232,196,74,0.25);">
                        <span class="text-xs font-semibold uppercase tracking-widest" style="color: #e8c44a;">Management System</span>
                    </div>
                    <h1 class="text-white font-black text-4xl xl:text-5xl leading-[1.05] tracking-tight max-w-sm">
                        Justice,<br />
                        <span style="color: #4ade80;">Unity</span><br />
                        &amp; Progress.
                    </h1>
                    <p class="text-white/60 text-sm mt-5 max-w-xs leading-relaxed">
                        The central platform for managing PRP Bauchi State's members, campaigns, elections, and financial operations.
                    </p>
                </div>

                <!-- Stats row -->
                <div class="flex gap-6 mt-auto pb-2">
                    <div v-for="stat in [
                        { value: '32,540', label: 'Members' },
                        { value: '20', label: 'LGAs' },
                        { value: '68%', label: 'Progress' },
                    ]" :key="stat.label" class="text-left">
                        <p class="text-white font-black text-xl leading-none">{{ stat.value }}</p>
                        <p class="text-white/40 text-[11px] mt-0.5 uppercase tracking-wider">{{ stat.label }}</p>
                    </div>
                </div>

                <!-- Motto -->
                <p class="text-white/25 text-[10px] font-medium uppercase tracking-widest mt-5 border-t border-white/10 pt-4">
                    People's Redemption Party · Bauchi State Chapter
                </p>
            </div>
        </div>

        <!-- ── Right panel: form ── -->
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-12 lg:px-16">

            <!-- Mobile logo -->
            <div class="flex lg:hidden items-center gap-3 mb-10">
                <div class="relative flex-shrink-0">
                    <!-- Outer ring -->
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center"
                        style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 50%, #e8c44a 100%); padding: 2px;"
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
                            <svg v-else viewBox="0 0 36 36" class="w-8 h-8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 3 L23 8 L30 8 L30 22 C30 28 18 33 18 33 C18 33 6 28 6 22 L6 8 L13 8 Z"
                                    fill="none" stroke="#e8c44a" stroke-width="1.2"/>
                                <text x="18" y="22" text-anchor="middle" font-size="7" font-weight="900"
                                    font-family="Arial,sans-serif" fill="#e8c44a" letter-spacing="0.5">PRP</text>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-black text-lg leading-none" style="color: #0d3b26;">PRP</p>
                    <p class="text-[#16a34a] text-[9px] font-bold uppercase tracking-[0.2em] mt-0.5">Bauchi State</p>
                </div>
            </div>

            <div class="w-full max-w-sm">

                <!-- Heading -->
                <div class="mb-8">
                    <h2 class="text-[#111827] font-black text-2xl tracking-tight">Sign in to your account</h2>
                    <p class="text-[#6b7280] text-sm mt-1">Enter your credentials to access the dashboard</p>
                </div>

                <!-- Status message -->
                <div
                    v-if="status"
                    class="mb-5 flex items-center gap-2 bg-[#dcfce7] border border-[#bbf7d0] text-[#15803d] text-sm font-medium rounded-lg px-4 py-3"
                >
                    <ShieldCheck class="w-4 h-4 flex-shrink-0" />
                    {{ status }}
                </div>

                <form @submit.prevent="submit" novalidate>
                    <div class="flex flex-col gap-5">

                        <!-- Email -->
                        <div class="flex flex-col gap-1.5">
                            <label for="email" class="text-[#374151] text-sm font-semibold">
                                Email address
                            </label>
                            <div class="relative">
                                <Mail class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9ca3af] pointer-events-none" />
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="email"
                                    placeholder="you@example.com"
                                    :class="[
                                        'w-full pl-10 pr-4 py-2.5 rounded-lg border text-sm text-[#111827] bg-white placeholder:text-[#d1d5db]',
                                        'outline-none transition-all duration-150',
                                        'focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a]',
                                        form.errors.email
                                            ? 'border-[#dc2626] bg-[#fef2f2]'
                                            : 'border-[#e5e7eb] hover:border-[#d1d5db]',
                                    ]"
                                />
                            </div>
                            <p v-if="form.errors.email" class="text-[#dc2626] text-xs font-medium flex items-center gap-1 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-[#dc2626] inline-block" />
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center justify-between">
                                <label for="password" class="text-[#374151] text-sm font-semibold">Password</label>
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    :tabindex="5"
                                    class="text-xs font-semibold text-[#16a34a] hover:text-[#0d3b26] underline-offset-2 hover:underline transition-colors"
                                >
                                    Forgot password?
                                </Link>
                            </div>
                            <div class="relative">
                                <Lock class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9ca3af] pointer-events-none" />
                                <input
                                    id="password"
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    :tabindex="2"
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    :class="[
                                        'w-full pl-10 pr-10 py-2.5 rounded-lg border text-sm text-[#111827] bg-white placeholder:text-[#d1d5db]',
                                        'outline-none transition-all duration-150',
                                        'focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a]',
                                        form.errors.password
                                            ? 'border-[#dc2626] bg-[#fef2f2]'
                                            : 'border-[#e5e7eb] hover:border-[#d1d5db]',
                                    ]"
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9ca3af] hover:text-[#374151] transition-colors"
                                    :aria-label="showPassword ? 'Hide password' : 'Show password'"
                                >
                                    <Eye v-if="!showPassword" class="w-4 h-4" />
                                    <EyeOff v-else class="w-4 h-4" />
                                </button>
                            </div>
                            <p v-if="form.errors.password" class="text-[#dc2626] text-xs font-medium flex items-center gap-1 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-[#dc2626] inline-block" />
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Remember me -->
                        <label class="flex items-center gap-2.5 cursor-pointer select-none group w-fit">
                            <div class="relative flex-shrink-0">
                                <input
                                    id="remember"
                                    v-model="form.remember"
                                    type="checkbox"
                                    :tabindex="3"
                                    class="sr-only peer"
                                />
                                <div
                                    :class="[
                                        'w-4 h-4 rounded border-2 transition-all duration-150 flex items-center justify-center',
                                        form.remember
                                            ? 'bg-[#16a34a] border-[#16a34a]'
                                            : 'bg-white border-[#d1d5db] group-hover:border-[#16a34a]/50',
                                    ]"
                                    @click="form.remember = !form.remember"
                                >
                                    <svg v-if="form.remember" class="w-2.5 h-2.5 text-white" viewBox="0 0 10 8" fill="none">
                                        <path d="M1 4L3.5 6.5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-sm text-[#374151]">Remember me for 30 days</span>
                        </label>

                        <!-- Submit Button styled to match active sidebar link state -->
                        <button
                            type="submit"
                            :tabindex="4"
                            :disabled="form.processing"
                            :class="[
                                'mt-1 w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-sm font-bold text-white transition-all duration-150',
                                'focus:outline-none focus:ring-2 focus:ring-[#16a34a]/40 focus:ring-offset-2',
                                form.processing
                                    ? 'bg-[#16a34a]/60 cursor-not-allowed'
                                    : 'active:scale-[0.98] shadow-sm hover:shadow-md',
                            ]"
                            :style="!form.processing ? 'background: linear-gradient(90deg, #22c55e, #16a34a); box-shadow: 0 2px 8px rgba(34,197,94,0.25);' : ''"
                        >
                            <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin" />
                            {{ form.processing ? 'Signing in…' : 'Sign in' }}
                        </button>
                    </div>

                    <!-- Register link -->
                    <p class="mt-6 text-center text-sm text-[#6b7280]">
                        Don't have an account?
                        <Link
                            :href="route('register')"
                            :tabindex="6"
                            class="text-[#16a34a] font-semibold hover:text-[#0d3b26] underline-offset-2 hover:underline transition-colors ml-1"
                        >
                            Request access
                        </Link>
                    </p>
                </form>
            </div>

            <!-- Footer -->
            <p class="mt-auto pt-10 text-[11px] text-[#9ca3af] text-center">
                © 2026 PRP Bauchi State Management System ·
                <span class="text-[#6b7280]">Smart Core ICT Service Consultant</span>
            </p>
        </div>
    </div>
</template>