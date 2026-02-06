<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, reactive, watch } from 'vue';
import { Mail, Sun, ArrowRight, Loader2, Check } from 'lucide-vue-next';
import { useTrans } from '@/composables/useTrans';
import { useTelemetry } from '@/composables/useTelemetry';

const { trans } = useTrans();
const { startSessionTime, sectionTimers, visitCount: telemetryVisitCount } = useTelemetry();

const consentGranted = computed(() => {
    if (typeof window === 'undefined') return false;
    return localStorage.getItem('cookie_consent') === 'granted';
});

const totalSessionTime = computed(() => {
    if (typeof window === 'undefined') return '00:00';
    // Calculate live time
    const now = Date.now();
    const seconds = Math.floor((now - startSessionTime.value) / 1000);
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    return `${m}:${s}`;
});

const topSection = computed(() => {
    const timers = sectionTimers.value;
    let maxTime = -1;
    let maxSection = '-';
    
    // Map IDs to friendly names
    const names: Record<string, string> = {
        'hero': 'Intro / Hero',
        'trust-bar': 'Zaufali nam',
        'roi': 'Kalkulator ROI',
        'contact': 'Formularz',
        'business-audit': 'Audyt Biznesowy'
    };

    for (const [section, time] of Object.entries(timers)) {
        if (Number(time) > maxTime) {
            maxTime = Number(time);
            maxSection = names[section] || section;
        }
    }
    
    // Return friendly name + formatted time
    /* 
       Optional: format time for section
       const m = Math.floor(maxTime / 60);
       const s = Math.round(maxTime % 60);
    */
    
    return maxSection;
});

const visitCount = computed(() => {
    return telemetryVisitCount.value;
});

const form = useForm({
    name: '',
    email: '',
    website: '',
    pain_point: '',
});

const isSuccess = ref(false);
const submitButtonRef = ref<HTMLElement | null>(null);
const containerRef = ref<HTMLElement | null>(null);
const isHoveringButton = ref(false);

// Mouse State (Global)
const mouse = ref({ x: 0, y: 0 });
const windowSize = ref({ w: 0, h: 0 });
let animationFrameId: number;

// Current Rendered State (for Smoothing)
const renderedSun = reactive({
    x: -30,
    y: 50,
    opacity: 0,
    size: 50
});

// 1. TYPING PROGRESS
const typingProgress = computed(() => {
    let score = 0;
    if (form.name.length > 0) score += 0.2;
    if (form.email.length > 2 && form.email.includes('@')) score += 0.2;
    if (form.website.length > 0) score += 0.1;
    if (form.pain_point.length > 0) {
        score += Math.min(form.pain_point.length / 40, 0.5); 
    }
    return Math.min(score, 1);
});

// 2. MOUSE PROXIMITY
const mouseProximity = computed(() => {
    if (!submitButtonRef.value || !windowSize.value.w) return 0;
    
    // Safety check for SSR or unmounted elements
    try {
        const btnRect = submitButtonRef.value.getBoundingClientRect();
        const btnCenter = {
            x: btnRect.left + btnRect.width / 2,
            y: btnRect.top + btnRect.height / 2
        };

        const dx = mouse.value.x - btnCenter.x;
        const dy = mouse.value.y - btnCenter.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        const maxDist = windowSize.value.h * 0.6; 
        
        if (distance < maxDist) {
            return Math.pow(1 - (distance / maxDist), 3);
        }
    } catch (e) {
        return 0;
    }
    return 0;
});

// 3. TARGET STATE CALCULATION
const targetSun = computed(() => {
    if (isHoveringButton.value) {
        return { x: 50, y: 50, opacity: 0.8, size: 80 };
    }

    const progress = typingProgress.value;
    const prox = mouseProximity.value;

    // TARGET X: Start at -30% (Left), End at 50% (Center)
    const baseX = -30 + (progress * 80); 
    
    // Add mouse influence only if window width is available
    let mouseInfluenceX = 0;
    let mouseInfluenceY = 0;

    if (windowSize.value.w > 0 && windowSize.value.h > 0) {
        mouseInfluenceX = (mouse.value.x / windowSize.value.w - 0.5) * 10;
        mouseInfluenceY = (mouse.value.y / windowSize.value.h - 0.5) * 10;
    }
    
    const currentX = baseX + mouseInfluenceX;
    const currentY = 50 + mouseInfluenceY;
    
    const baseOpacity = progress * 0.6;
    const finalOpacity = baseOpacity * (1 + prox * 0.2);

    return {
        x: currentX,
        y: currentY,
        opacity: Math.min(finalOpacity, 0.8), 
        size: 50 + (progress * 50) 
    };
});

// 4. ANIMATION LOOP (LERP)
const animate = () => {
    const target = targetSun.value;
    const lerpFactor = 0.1; // Adjust for smoothness (0.05 = slow/heavy, 0.2 = fast/snappy)

    renderedSun.x += (target.x - renderedSun.x) * lerpFactor;
    renderedSun.y += (target.y - renderedSun.y) * lerpFactor;
    renderedSun.opacity += (target.opacity - renderedSun.opacity) * lerpFactor;
    renderedSun.size += (target.size - renderedSun.size) * lerpFactor;

    animationFrameId = requestAnimationFrame(animate);
};

// URL Fixer
const fixUrl = () => {
    if (form.website && !/^https?:\/\//i.test(form.website)) {
        form.website = 'https://' + form.website;
    }
};

const updateMouse = (e: MouseEvent) => {
    mouse.value = { x: e.clientX, y: e.clientY };
};
const updateWindow = () => {
    windowSize.value = { w: window.innerWidth, h: window.innerHeight };
};

onMounted(() => {
    if (typeof window !== 'undefined') {
        window.addEventListener('mousemove', updateMouse);
        window.addEventListener('resize', updateWindow);
        updateWindow();
        animate(); // Start loop
    }
});

onUnmounted(() => {
    if (typeof window !== 'undefined') {
        window.removeEventListener('mousemove', updateMouse);
        window.removeEventListener('resize', updateWindow);
        cancelAnimationFrame(animationFrameId);
    }
});

const finalStats = ref<{
    totalSessionTime: string;
    topSection: string;
    visitCount: number;
    sessionId?: string | null;
} | null>(null);

const submit = () => {
    fixUrl(); // Auto-fix before submit

    // Snapshot telemetry data
    finalStats.value = {
        totalSessionTime: totalSessionTime.value,
        topSection: topSection.value,
        visitCount: visitCount.value,
        sessionId: startSessionTime.value ? 'SESSION-' + Date.now().toString(36).toUpperCase() : null // Mock or grab real ID if available
    };
    
    // Logic to grab real ID if in store, but for now we snapshot visual data. 
    // Ideally we grab from useTelemetry if exposed. 
    // Let's grab it from local storage directly for display if needed or keep it simple.
    
    // Re-grab ID from storage strictly for valid display
    const storedId = typeof localStorage !== 'undefined' ? localStorage.getItem('telemetry_session_id') : null;
    if (storedId) finalStats.value.sessionId = storedId;


    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
             isSuccess.value = true;
             form.reset();
        },
        onError: () => {
            console.error('Submission failed');
        }
    });
};

// Background Style (Uses RENDERED state, not target)
const backgroundStyle = computed(() => {
    if (isSuccess.value) return {}; 
    const s = renderedSun;
    return {
        background: `radial-gradient(circle ${s.size}vmax at ${s.x}% ${s.y}%, rgba(255, 180, 80, ${s.opacity}), transparent 60%)`
    };
});
</script>

<template>
    <section id="contact" ref="containerRef" class="relative py-24 sm:py-32 overflow-hidden">
        
        <!-- GLOBAL CINEMATIC OVERLAY (Fixed to Viewport) -->
        <div 
            class="fixed inset-0 pointer-events-none z-0"
            :style="backgroundStyle"
        ></div>

        <!-- Content Container -->
        <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-8 transition-opacity duration-700">
            
            <!-- VIEW A: Contact Form (Visible when NOT success) -->
            <div v-if="!isSuccess" class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
                <!-- Left Column -->
                <div class="space-y-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-sm font-medium text-orange-400 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        {{ trans('contact.accepting') }}
                    </div>

                    <h2 class="text-5xl font-bold tracking-tight text-white sm:text-6xl leading-tight">
                        {{ trans('contact.title_start') }} <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-yellow-200">{{ trans('contact.title_end') }}</span>
                    </h2>
                    
                    <p class="text-xl text-gray-400 leading-relaxed max-w-lg">
                        {{ trans('contact.subtitle') }}
                    </p>
                    
                    <div class="flex items-center gap-4 pt-4">
                        <div class="h-14 w-14 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-colors cursor-pointer backdrop-blur-md">
                            <Mail class="h-6 w-6" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-widest font-semibold">{{ trans('contact.email_us') }}</p>
                            <a href="mailto:hello@digitalfoundry.com" class="text-xl font-medium text-foreground hover:text-primary transition-colors">
                                hello@digitalfoundry.com
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form -->
                <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 p-8 sm:p-10 rounded-3xl shadow-2xl">
                    <form @submit.prevent="submit" id="contact-form" class="space-y-6">
                         <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-medium text-gray-400">{{ trans('contact.form.name') }}</label>
                                <input id="name" v-model="form.name" type="text" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500/50 focus:ring-1 focus:ring-orange-500/50 transition-all font-light tracking-wide" :placeholder="trans('contact.form.name_ph')" />
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-gray-400">{{ trans('contact.form.email') }}</label>
                                <input id="email" v-model="form.email" type="email" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500/50 focus:ring-1 focus:ring-orange-500/50 transition-all font-light tracking-wide" :placeholder="trans('contact.form.email_ph')" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="website" class="text-sm font-medium text-gray-400">{{ trans('contact.form.website') }}</label>
                            <input 
                                id="website" 
                                v-model="form.website" 
                                type="text" 
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500/50 focus:ring-1 focus:ring-orange-500/50 transition-all font-light tracking-wide" 
                                :placeholder="trans('contact.form.website_ph')"
                                @blur="fixUrl" 
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="pain_point" class="text-sm font-medium text-gray-400">{{ trans('contact.form.challenge') }}</label>
                            <textarea id="pain_point" v-model="form.pain_point" rows="4" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:border-orange-500/50 focus:ring-1 focus:ring-orange-500/50 transition-all resize-none font-light tracking-wide" :placeholder="trans('contact.form.challenge_ph')"></textarea>
                        </div>

                        <button 
                            ref="submitButtonRef"
                            type="submit" 
                            :disabled="form.processing"
                            class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-white px-8 py-4 text-base font-bold text-black transition-all hover:bg-orange-400 hover:text-white disabled:opacity-70 disabled:hover:bg-white disabled:hover:text-black"
                            @mouseenter="isHoveringButton = true"
                            @mouseleave="isHoveringButton = false"
                        >
                            <span class="relative z-10 flex items-center gap-2">
                                <Loader2 v-if="form.processing" class="h-5 w-5 animate-spin" />
                                <span v-else>{{ form.processing ? trans('contact.submitting') : trans('contact.submit') }}</span>
                                <ArrowRight v-if="!form.processing" class="h-5 w-5 transition-transform group-hover:translate-x-1" />
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- VIEW B: Success State (Two-Panel Layout) -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center animate-fade-in-up">
                
                <!-- Panel A: Standard "Message Sent" (Friendly) -->
                <div class="bg-[#fefce8] p-10 rounded-3xl shadow-xl text-center md:text-left border border-orange-100 flex flex-col justify-center h-full min-h-[400px]">
                     <div class="mb-8 mx-auto md:mx-0 h-20 w-20 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                        <Check class="h-10 w-10" />
                    </div>
                    <h2 class="text-4xl md:text-5xl font-serif text-gray-900 mb-6 drop-shadow-sm tracking-tight leading-tight">
                        To początek nowej podróży!
                    </h2>
                    <p class="text-xl text-gray-600 font-light font-sans mb-8">
                        Wkrótce się odezwiemy, aby rozświetlić Twój biznes.
                    </p>
                    <button @click="isSuccess = false" class="text-gray-400 text-sm hover:text-gray-600 transition-colors self-center md:self-start">
                         ← Wróć do formularza
                    </button>
                </div>

                <!-- Panel B: Tech Report (Technical - Light Mode) -->
                <!-- Scenario 1: No Consent -->
                <div v-if="!consentGranted" class="bg-gray-50 border border-gray-200 border-dashed p-8 rounded-3xl h-full min-h-[400px] flex flex-col relative overflow-hidden">
                     <div class="relative z-10 flex flex-col h-full opacity-60">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-200 pb-4">
                            <div class="h-3 w-3 rounded-full bg-gray-300"></div>
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Raport Analityczny</h3>
                        </div>

                        <div class="flex flex-col items-center justify-center flex-grow py-8 space-y-4">
                            <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mb-2">
                                <span class="text-2xl">🔒</span>
                            </div>
                            <p class="text-gray-400 font-medium text-center">Brak zgody na pliki cookies</p>
                            <p class="text-gray-400 text-sm text-center max-w-xs">Gdybyś wyraził zgodę, w tym miejscu pojawiłoby się podsumowanie Twojej wizyty.</p>
                        </div>

                        <div class="space-y-4 my-8 font-mono text-sm pointer-events-none blur-[2px] select-none opacity-50">
                            <div class="flex justify-between border-b border-gray-200 pb-2 border-dashed">
                                <span class="text-gray-400">Czas na stronie:</span>
                                <span class="text-gray-400 font-bold">--:--</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-200 pb-2 border-dashed">
                                <span class="text-gray-400">Ulubiona sekcja:</span>
                                <span class="text-gray-400 font-bold">---</span>
                            </div>
                             <div class="flex justify-between border-b border-gray-200 pb-2 border-dashed">
                                <span class="text-gray-400">Wizyt:</span>
                                <span class="text-gray-400 font-bold">--</span>
                            </div>
                        </div>

                        <div class="text-xs text-gray-400 mt-auto pt-4 border-t border-gray-200 text-center">
                             Dane nie zostały zebrane.
                        </div>
                    </div>
                </div>

                <!-- Scenario 2: Consent Granted -->
                <div v-else class="bg-white border border-gray-200 p-8 rounded-3xl h-full min-h-[400px] flex flex-col relative overflow-hidden shadow-sm">
                     <div class="relative z-10 flex flex-col h-full">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <div class="h-3 w-3 rounded-full bg-green-500 animate-pulse"></div>
                            <h3 class="text-sm font-semibold text-slate-700 tracking-wider uppercase">Raport Analityczny</h3>
                        </div>

                        <p class="text-slate-600 mb-auto text-sm leading-relaxed">
                            Dzięki Twojej zgodzie, nasz system przeanalizował Twoją sesję.
                        </p>

                        <div class="space-y-4 my-8 font-mono text-sm">
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-slate-500">Czas na stronie:</span>
                                <span class="text-slate-800 font-bold">{{ finalStats?.totalSessionTime || '...' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-slate-500">Ulubiona sekcja:</span>
                                <span class="text-slate-800 font-bold truncate max-w-[150px] text-right">{{ finalStats?.topSection || '...' }}</span>
                            </div>
                             <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-slate-500">Twoich wizyt:</span>
                                <span class="text-slate-800 font-bold">{{ finalStats?.visitCount || '...' }}</span>
                            </div>
                        </div>

                        <div class="bg-blue-50 rounded-lg p-4 mt-auto">
                             <p class="text-xs text-blue-600 font-medium">Systemy, które budujemy, dostarczają takich danych w czasie rzeczywistym. Twój też może to robić.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<style scoped>
.font-serif {
    font-family: 'Playfair Display', serif; 
}
</style>
