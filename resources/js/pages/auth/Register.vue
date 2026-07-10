<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3'
import { LoaderCircle, Eye, EyeOff, Lock, Mail, User, ShieldCheck } from 'lucide-vue-next'
import { ref } from 'vue'
import logoUrl from '@/assets/logo.jpg'

const showPassword = ref(false)
const showConfirm = ref(false)

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}

const steps = [
    'Fill in your name, email and a secure password',
    'Submit your registration request',
    'Await approval from the State Administrator',
]

const stats = [
    { value: '32,540', label: 'Members' },
    { value: '20', label: 'LGAs' },
    { value: '320', label: 'Team' },
]
</script>

<template>
    <Head title="Request Access – PRP Bauchi State" />

    <div class="min-h-screen bg-green-50 flex flex-col lg:flex-row">

        <!-- ── Left panel: brand / illustration (hidden below lg) ── -->
        <div
            class="hidden lg:flex lg:w-[52%] xl:w-[48%] flex-col relative overflow-hidden"
            style="background: linear-gradient(180deg, #0d3b26 0%, #092b1c 40%, #061a11 100%);"
        >
            <div class="absolute -top-32 -left-32 w-[420px] h-[420px] rounded-full border border-white/10"></div>
            <div class="absolute -top-20 -left-20 w-[300px] h-[300px] rounded-full border border-white/8"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] rounded-full border border-white/6 translate-x-1/3 translate-y-1/3"></div>

            <div
                class="absolute top-0 right-0 w-28 h-full bg-[#dc2626]/10 origin-top-right"
                style="clip-path: polygon(100% 0, 100% 100%, 60% 100%, 20% 0)"
            ></div>

            <div class="relative z-10 flex flex-col h-full px-8 xl:px-12 py-8 xl:py-10 overflow-y-auto">

                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <div
                            class="w-11 h-11 rounded-full flex items-center justify-center"
                            style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 50%, #e8c44a 100%); padding: 2px; box-shadow: 0 0 0 2px rgba(232,196,74,0.25), 0 4px 12px rgba(0,0,0,0.4);"
                        >
                            <div class="w-full h-full rounded-full flex items-center justify-center overflow-hidden" style="background: linear-gradient(145deg, #0d3b26, #061a11);">
                                <img v-if="logoUrl" :src="logoUrl" alt="PRP" class="w-full h-full rounded-full object-cover" />
                                <svg v-else viewBox="0 0 36 36" class="w-9 h-9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 3 L23 8 L30 8 L30 22 C30 28 18 33 18 33 C18 33 6 28 6 22 L6 8 L13 8 Z" fill="none" stroke="#e8c44a" stroke-width="1.2"/>
                                    <path d="M18 3 L23 8 L13 8 Z" fill="#e8c44a" opacity="0.3"/>
                                    <text x="18" y="22" text-anchor="middle" font-size="7" font-weight="900" font-family="Arial,sans-serif" fill="#e8c44a" letter-spacing="0.5">PRP</text>
                                    <circle cx="11" cy="13" r="1" fill="#e8c44a"/>
                                    <circle cx="25" cy="13" r="1" fill="#e8c44a"/>
                                </svg>
                            </div>
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 flex items-center justify-center" style="background: #22c55e; border-color: #0d3b26;"></div>
                    </div>
                    <div>
                        <p class="font-black text-xl tracking-widest leading-none" style="color: #e8c44a; text-shadow: 0 1px 4px rgba(232,196,74,0.4);">PRP</p>
                        <p class="font-bold text-[10px] uppercase mt-1 tracking-[0.25em]" style="color: rgba(255,255,255,0.55);">Bauchi State</p>
                    </div>
                </div>

                <div class="mt-auto mb-auto pt-14 xl:pt-20">
                    <div class="inline-block border rounded-full px-3 py-1 mb-6" style="background: rgba(232,196,74,0.1); border-color: rgba(232,196,74,0.25);">
                        <span class="text-xs font-semibold uppercase tracking-widest" style="color: #e8c44a;">Join the Movement</span>
                    </div>
                    <h1 class="text-white font-black text-3xl xl:text-5xl leading-[1.05] tracking-tight max-w-sm">
                        Be part of<br />
                        <span style="color: #4ade80;">positive</span><br />
                        change.
                    </h1>
                    <p class="text-white/60 text-sm mt-5 max-w-xs leading-relaxed">
                        Register to gain access to the PRP Bauchi State Management System and contribute to a united, peaceful and prosperous Bauchi State.
                    </p>

                    <div class="mt-8 space-y-3.5">
                        <div v-for="(step, i) in steps" :key="i" class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full border flex items-center justify-center flex-shrink-0" style="background: rgba(232,196,74,0.1); border-color: rgba(232,196,74,0.35);">
                                <span style="color: #e8c44a;" class="text-[10px] font-black">{{ i + 1 }}</span>
                            </div>
                            <span class="text-white/70 text-sm font-medium">{{ step }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-6 mt-auto pb-2">
                    <div v-for="stat in stats" :key="stat.label" class="text-left">
                        <p class="text-white font-black text-xl leading-none">{{ stat.value }}</p>
                        <p class="text-white/40 text-[11px] mt-0.5 uppercase tracking-wider">{{ stat.label }}</p>
                    </div>
                </div>

                <p class="text-white/25 text-[10px] font-medium uppercase tracking-widest mt-5 border-t border-white/10 pt-4">
                    People's Redemption Party · Bauchi State Chapter
                </p>
            </div>
        </div>

        <!-- ── Right panel: form ── -->
        <div class="flex-1 flex flex-col items-center justify-center px-4 sm:px-8 lg:px-12 xl:px-16 py-8 sm:py-12">

            <!-- Mobile logo -->
            <div class="flex lg:hidden items-center gap-3 mb-8 sm:mb-10">
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #e8c44a 0%, #c9960a 50%, #e8c44a 100%); padding: 2px;">
                        <div class="w-full h-full rounded-full flex items-center justify-center overflow-hidden" style="background: linear-gradient(145deg, #0d3b26, #061a11);">
                            <img v-if="logoUrl" :src="logoUrl" alt="PRP" class="w-full h-full rounded-full object-cover" />
                            <svg v-else viewBox="0 0 36 36" class="w-8 h-8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 3 L23 8 L30 8 L30 22 C30 28 18 33 18 33 C18 33 6 28 6 22 L6 8 L13 8 Z" fill="none" stroke="#e8c44a" stroke-width="1.2"/>
                                <text x="18" y="22" text-anchor="middle" font-size="7" font-weight="900" font-family="Arial,sans-serif" fill="#e8c44a" letter-spacing="0.5">PRP</text>
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

                <div class="mb-6 sm:mb-8">
                    <h2 class="text-[#111827] font-black text-xl sm:text-2xl tracking-tight">Create your account</h2>
                    <p class="text-[#6b7280] text-sm mt-1">Fill in your details to request system access</p>
                </div>

                <form @submit.prevent="submit" novalidate>
                    <div class="flex flex-col gap-4">

                        <!-- Full name -->
                        <div class="flex flex-col gap-1.5">
                            <label for="name" class="text-[#374151] text-sm font-semibold">Full name</label>
                            <div class="relative">
                                <User class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9ca3af] pointer-events-none" />
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="name"
                                    placeholder="Alh. Usman Mohammed"
                                    :class="[
                                        'w-full pl-10 pr-4 py-2.5 rounded-lg border text-sm text-[#111827] bg-white placeholder:text-[#d1d5db]',
                                        'outline-none transition-all duration-150',
                                        'focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a]',
                                        form.errors.name ? 'border-[#dc2626] bg-[#fef2f2]' : 'border-[#e5e7eb] hover:border-[#d1d5db]',
                                    ]"
                                />
                            </div>
                            <p v-if="form.errors.name" class="text-[#dc2626] text-xs font-medium flex items-center gap-1 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-[#dc2626] inline-block"></span>
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col gap-1.5">
                            <label for="email" class="text-[#374151] text-sm font-semibold">Email address</label>
                            <div class="relative">
                                <Mail class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9ca3af] pointer-events-none" />
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    required
                                    :tabindex="2"
                                    autocomplete="email"
                                    placeholder="you@example.com"
                                    :class="[
                                        'w-full pl-10 pr-4 py-2.5 rounded-lg border text-sm text-[#111827] bg-white placeholder:text-[#d1d5db]',
                                        'outline-none transition-all duration-150',
                                        'focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a]',
                                        form.errors.email ? 'border-[#dc2626] bg-[#fef2f2]' : 'border-[#e5e7eb] hover:border-[#d1d5db]',
                                    ]"
                                />
                            </div>
                            <p v-if="form.errors.email" class="text-[#dc2626] text-xs font-medium flex items-center gap-1 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-[#dc2626] inline-block"></span>
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password -->
                        <div class="flex flex-col gap-1.5">
                            <label for="password" class="text-[#374151] text-sm font-semibold">Password</label>
                            <div class="relative">
                                <Lock class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9ca3af] pointer-events-none" />
                                <input
                                    id="password"
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    :tabindex="3"
                                    autocomplete="new-password"
                                    placeholder="Min. 8 characters"
                                    :class="[
                                        'w-full pl-10 pr-10 py-2.5 rounded-lg border text-sm text-[#111827] bg-white placeholder:text-[#d1d5db]',
                                        'outline-none transition-all duration-150',
                                        'focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a]',
                                        form.errors.password ? 'border-[#dc2626] bg-[#fef2f2]' : 'border-[#e5e7eb] hover:border-[#d1d5db]',
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
                                <span class="w-1 h-1 rounded-full bg-[#dc2626] inline-block"></span>
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Confirm password -->
                        <div class="flex flex-col gap-1.5">
                            <label for="password_confirmation" class="text-[#374151] text-sm font-semibold">Confirm password</label>
                            <div class="relative">
                                <Lock class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9ca3af] pointer-events-none" />
                                <input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    :type="showConfirm ? 'text' : 'password'"
                                    required
                                    :tabindex="4"
                                    autocomplete="new-password"
                                    placeholder="Re-enter password"
                                    :class="[
                                        'w-full pl-10 pr-10 py-2.5 rounded-lg border text-sm text-[#111827] bg-white placeholder:text-[#d1d5db]',
                                        'outline-none transition-all duration-150',
                                        'focus:ring-2 focus:ring-[#16a34a]/30 focus:border-[#16a34a]',
                                        form.errors.password_confirmation ? 'border-[#dc2626] bg-[#fef2f2]' : 'border-[#e5e7eb] hover:border-[#d1d5db]',
                                    ]"
                                />
                                <button
                                    type="button"
                                    @click="showConfirm = !showConfirm"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9ca3af] hover:text-[#374151] transition-colors"
                                    :aria-label="showConfirm ? 'Hide password' : 'Show password'"
                                >
                                    <Eye v-if="!showConfirm" class="w-4 h-4" />
                                    <EyeOff v-else class="w-4 h-4" />
                                </button>
                            </div>
                            <p v-if="form.errors.password_confirmation" class="text-[#dc2626] text-xs font-medium flex items-center gap-1 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-[#dc2626] inline-block"></span>
                                {{ form.errors.password_confirmation }}
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :tabindex="5"
                            :disabled="form.processing"
                            :class="[
                                'mt-2 w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-lg text-sm font-bold text-white transition-all duration-150',
                                'focus:outline-none focus:ring-2 focus:ring-[#16a34a]/40 focus:ring-offset-2',
                                form.processing ? 'bg-[#16a34a]/60 cursor-not-allowed' : 'active:scale-[0.98] shadow-sm hover:shadow-md',
                            ]"
                            :style="!form.processing ? 'background: linear-gradient(90deg, #22c55e, #16a34a); box-shadow: 0 2px 8px rgba(34,197,94,0.25);' : ''"
                        >
                            <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin" />
                            {{ form.processing ? 'Creating account…' : 'Create account' }}
                        </button>
                    </div>

                    <p class="mt-6 text-center text-sm text-[#6b7280]">
                        Already have an account?
                        <Link
                            :href="route('login')"
                            :tabindex="6"
                            class="text-[#16a34a] font-semibold hover:text-[#0d3b26] underline-offset-2 hover:underline transition-colors ml-1"
                        >
                            Sign in
                        </Link>
                    </p>
                </form>
            </div>

            <p class="mt-8 sm:mt-auto pt-6 sm:pt-10 text-[11px] text-[#9ca3af] text-center px-4">
                © 2026 PRP Bauchi State Management System ·
                <span class="text-[#6b7280]">Smart Core ICT Service Consultant</span>
            </p>
        </div>
    </div>
</template>