<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowRight, BarChart, Sparkles } from 'lucide-vue-next';
import { useTrans } from '@/composables/useTrans';
import TypewriterText from '@/Components/TypewriterText.vue';
import { Button } from '@/Components/ui/button';

const { trans } = useTrans();
import InteractiveGrid from '@/Components/InteractiveGrid.vue';

const scrollToAudit = () => {
    document.getElementById('audit')?.scrollIntoView({ behavior: 'smooth' });
};

const scrollToContact = () => {
    document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <section class="relative overflow-hidden bg-transparent pt-16 pb-32 sm:pt-24 sm:pb-40 lg:pt-32 lg:pb-48">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 z-0 pointer-events-none">
             <div class="absolute top-0 right-1/4 -z-10 h-[600px] w-[600px] rounded-full bg-accent/5 blur-[120px]"></div>
             <div class="absolute bottom-0 left-1/4 -z-10 h-[500px] w-[500px] rounded-full bg-primary/5 blur-[100px]"></div>
             
             <!-- Grid Pattern -->
             <InteractiveGrid />
        </div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl text-center">
                
                <!-- Trust Pill -->
                <div class="mb-8 flex justify-center fade-in-up">
                    <span class="inline-flex items-center rounded-full border border-accent/20 bg-accent/10 px-3 py-1 text-sm font-medium text-accent">
                        <span class="mr-2 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full opacity-75 bg-accent"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                        </span>
                        Opening availability for Q3 2026
                    </span>
                </div>

                <!-- Headline (Block Layout for Absolute Stability) -->
                <h1 class="text-4xl font-bold tracking-tight text-foreground sm:text-6xl lg:text-7xl leading-tight sm:leading-tight lg:leading-tight mb-8">
                    <span class="block mb-2 sm:mb-4">{{ trans('hero.title_start') }}</span>
                    
                    <span class="block min-h-[1.5em] sm:min-h-[1.3em] text-accent relative">
                        <span class="relative inline-block">
                            <TypewriterText 
                                :text="trans<string[]>('hero.title_typing')" 
                                :loop="true" 
                                :speed="100"
                                :deleteSpeed="50"
                                :delay="1500"
                            />
                            <svg class="absolute -bottom-2 left-0 h-3 w-full text-accent/30" viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3" fill="none" />
                            </svg>
                        </span>
                    </span>
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto max-w-2xl text-lg text-muted-foreground sm:text-xl leading-relaxed mb-10">
                    {{ trans('hero.subtitle') }}
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                    <!-- Primary CTA -->
                    <a 
                        href="#contact" 
                        @click.prevent="scrollToContact"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-8 py-4 text-base font-semibold text-accent-foreground shadow-lg shadow-accent/20 transition-all hover:bg-accent/90 hover:scale-105 cursor-pointer"
                    >
                        {{ trans('nav.book_call') }}
                        <ArrowRight class="h-5 w-5" />
                    </a>

                    <!-- Secondary CTA -->
                    <Link 
                        href="/case-studies" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg border border-border bg-background/50 px-8 py-4 text-base font-semibold text-muted-foreground backdrop-blur-sm transition-all hover:bg-muted hover:text-foreground hover:border-primary/20"
                    >
                        <BarChart class="h-5 w-5" />
                        {{ trans('nav.case_studies') }}
                    </Link>
                </div>

                <!-- Social Proof / Tech Stack Hint -->
                 <div class="mt-12 flex justify-center gap-6 opacity-60 grayscale transition-all hover:grayscale-0">
                    <!-- Simple text representations for now, replace with SVGs later -->
                     <span class="text-xs font-mono text-muted-foreground font-semibold tracking-wider">LARAVEL 12</span>
                     <span class="text-xs font-mono text-muted-foreground font-semibold tracking-wider">VUE 3</span>
                     <span class="text-xs font-mono text-muted-foreground font-semibold tracking-wider">TAILWIND</span>
                 </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Simple enter animation */
.fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes fade-in-up {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

