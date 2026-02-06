<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, reactive, watch } from 'vue';
import { Mail, Sun, ArrowRight, Loader2, Check } from 'lucide-vue-next';
import { useTrans } from '@/composables/useTrans';

const { trans } = useTrans();

const form = useForm({
    name: '',
    email: '',
    website: '',
    pain_point: '',
});

const isSuccess = ref(false);
const isSettled = ref(false); // Animation trigger
const isFixed = ref(true); // Positioning mode
const submitButtonRef = ref<HTMLElement | null>(null);
const containerRef = ref<HTMLElement | null>(null);
const isHoveringButton = ref(false);

const overlayStyle = reactive({
    top: '0px',
    left: '0px',
    width: '100vw',
    height: '100vh',
    borderRadius: '0px',
});

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

const triggerShrink = () => {
    if (isSettled.value || !containerRef.value) return;
    
    const rect = containerRef.value.getBoundingClientRect();
    
    overlayStyle.top = `${rect.top}px`;
    overlayStyle.left = `${rect.left}px`;
    overlayStyle.width = `${rect.width}px`;
    overlayStyle.height = `${rect.height}px`;
    overlayStyle.borderRadius = '24px'; 
    
    isSettled.value = true;

    setTimeout(() => {
        isFixed.value = false;
        overlayStyle.top = '0';
        overlayStyle.left = '0';
        overlayStyle.width = '100%';
        overlayStyle.height = '100%';
    }, 1000); 
};

const submit = () => {
    fixUrl(); // Auto-fix before submit
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => {
             isSuccess.value = true;
             form.reset();
             setTimeout(() => {
                 triggerShrink();
             }, 4000);
        },
        onError: () => {
            // Optional: Handle error (Inertia handles validation errors automatically via props errors)
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

        <!-- SUCCESS OVERLAY (Morphing) -->
        <div 
            v-if="isSuccess"
            class="z-50 flex flex-col items-center justify-center text-center overflow-hidden cursor-pointer"
            :class="[
                isFixed ? 'fixed' : 'absolute',
                isSettled ? 'bg-[#fefce8] shadow-2xl' : 'bg-[#fefce8]'
            ]"
            :style="isFixed ? overlayStyle : { inset: 0, borderRadius: '1.5rem' }"
            style="transition: top 1s ease-in-out, left 1s ease-in-out, width 1s ease-in-out, height 1s ease-in-out, border-radius 1s;"
            @click="triggerShrink"
        >
            <!-- Large Fullscreen Content -->
            <div 
                class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-1000"
                :class="isSettled ? 'opacity-0 scale-90 delay-0' : 'opacity-100 scale-100 delay-300'"
            >
                <div class="mb-8 mx-auto h-24 w-24 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center animate-pulse">
                    <Sun class="h-12 w-12" />
                </div>
                <h2 class="text-5xl md:text-7xl font-serif text-gray-900 mb-6 drop-shadow-sm tracking-tight leading-tight px-4">
                    {{ trans('contact.success_title') }}
                </h2>
                <p class="text-2xl md:text-3xl text-gray-600 font-light max-w-2xl mx-auto px-4 font-sans">
                    {{ trans('contact.success_msg') }}
                </p>
                <p class="mt-12 text-gray-400 text-sm animate-bounce">{{ trans('contact.close') }}</p>
            </div>

            <!-- Shrink/Settled Content -->
            <div 
                class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-1000"
                :class="isSettled ? 'opacity-100 scale-100 delay-500' : 'opacity-0 scale-110'"
            >
                 <div class="mb-6 rounded-full bg-green-100 p-4 text-green-600">
                    <Check class="h-8 w-8" />
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ trans('contact.sent_title') }}</h3>
                <p class="text-gray-600 max-w-md px-4">
                    {{ trans('contact.sent_msg') }}
                </p>
            </div>
            
             <div class="absolute inset-0 opacity-20 pointer-events-none bg-[url('https://grainy-gradients.vercel.app/noise.svg')]"></div>
        </div>

        <!-- Content Container -->
        <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-8 transition-opacity duration-700" :class="{'opacity-0': isSuccess}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
                
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
        </div>
    </section>
</template>

<style scoped>
.font-serif {
    font-family: 'Playfair Display', serif; 
}
</style>
