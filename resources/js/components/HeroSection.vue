<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, BarChart } from 'lucide-vue-next';
</script>

<template>
    <section class="relative overflow-hidden bg-background pt-16 pb-32 sm:pt-24 sm:pb-40 lg:pt-32 lg:pb-48">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 z-0">
             <div class="absolute top-0 right-1/4 -z-10 h-[600px] w-[600px] rounded-full bg-accent/5 blur-[120px]"></div>
             <div class="absolute bottom-0 left-1/4 -z-10 h-[500px] w-[500px] rounded-full bg-primary/5 blur-[100px]"></div>
             
             <!-- Grid Pattern -->
             <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] mask-image-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                
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

                <!-- Headline -->
                <h1 class="text-4xl font-bold tracking-tight text-foreground sm:text-6xl lg:text-7xl leading-tight sm:leading-tight lg:leading-tight mb-8">
                    Turn Custom Software into Your <span class="text-accent relative whitespace-nowrap">
                        Competitive Advantage
                        <svg class="absolute -bottom-2.5 left-0 h-3 w-full text-accent/30" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="3" fill="none" />
                        </svg>
                    </span>.
                </h1>

                <!-- Subheadline -->
                <p class="mx-auto max-w-2xl text-lg text-muted-foreground sm:text-xl leading-relaxed mb-10">
                    Stop relying on fragile spreadsheets. We build dedicated Laravel + Vue systems that automate your operations and secure your growth.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                    <!-- Primary CTA -->
                    <Link 
                        href="/strategy-call" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-8 py-4 text-base font-semibold text-accent-foreground shadow-lg shadow-accent/20 transition-all hover:bg-accent/90 hover:scale-105"
                    >
                        Get a Free Strategy Audit
                        <ArrowRight class="h-5 w-5" />
                    </Link>

                    <!-- Secondary CTA -->
                    <Link 
                        href="/case-studies" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg border border-border bg-background/50 px-8 py-4 text-base font-semibold text-muted-foreground backdrop-blur-sm transition-all hover:bg-muted hover:text-foreground hover:border-primary/20"
                    >
                        <BarChart class="h-5 w-5" />
                        View ROI Case Studies
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

