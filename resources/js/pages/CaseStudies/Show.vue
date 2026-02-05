<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { 
    AlertTriangle, 
    CheckCircle, 
    ArrowRight, 
    TrendingUp, 
    Activity 
} from 'lucide-vue-next';

interface CaseStudy {
    id: number;
    title: string;
    client_industry: string;
    cover_image_path: string;
    challenge_summary: string;
    solution_summary: string;
    roi_stats: Record<string, string>;
    tech_stack: string[];
}

const props = defineProps<{
    caseStudy: CaseStudy;
}>();
</script>

<template>
    <Head :title="`${caseStudy.title} - Case Study`" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="relative w-full bg-muted/20 border-b border-border">
            <div class="absolute inset-0 bg-gradient-to-b from-background/5 to-background z-0"></div>
            
            <div class="container relative z-10 mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                <div class="max-w-3xl">
                    <span class="inline-block mb-4 text-sm font-semibold uppercase tracking-wider text-accent">
                        {{ caseStudy.client_industry }} Success Story
                    </span>
                    <h1 class="text-4xl font-extrabold tracking-tight text-foreground sm:text-5xl lg:text-6xl mb-6">
                        {{ caseStudy.title }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <!-- Impact Grid (ROI Stats) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16 -mt-20 relative z-20">
                <div 
                    v-for="(value, key) in caseStudy.roi_stats" 
                    :key="key"
                    class="bg-card border border-border rounded-xl p-6 shadow-xl shadow-black/5 flex flex-col items-center text-center hover:scale-105 transition-transform duration-300"
                >
                    <span class="text-sm font-medium text-muted-foreground uppercase tracking-wide mb-2">{{ key }}</span>
                    <span class="text-3xl sm:text-4xl font-black text-accent">{{ value }}</span>
                </div>
            </div>

            <!-- The Narrative (Pain vs Fix) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 mb-20">
                
                <!-- The Pain -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 rounded-lg bg-orange-500/10 text-orange-500">
                            <AlertTriangle class="h-6 w-6" />
                        </div>
                        <h2 class="text-2xl font-bold text-foreground">The Challenge</h2>
                    </div>
                    <p class="text-lg text-muted-foreground leading-relaxed">
                        {{ caseStudy.challenge_summary }}
                    </p>
                    <div class="h-1 w-20 bg-orange-500/20 rounded-full mt-4"></div>
                </div>

                <!-- The Fix -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-500">
                            <CheckCircle class="h-6 w-6" />
                        </div>
                        <h2 class="text-2xl font-bold text-foreground">The Solution</h2>
                    </div>
                    <p class="text-lg text-muted-foreground leading-relaxed">
                        {{ caseStudy.solution_summary }}
                    </p>
                    <div class="h-1 w-20 bg-emerald-500/20 rounded-full mt-4"></div>
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="mb-20">
                 <h3 class="text-lg font-semibold text-foreground mb-6">Technologies Deployed</h3>
                 <div class="flex flex-wrap gap-3">
                    <span 
                        v-for="tech in caseStudy.tech_stack" 
                        :key="tech"
                        class="inline-flex items-center px-4 py-2 rounded-lg border border-border bg-muted/50 text-sm font-medium text-muted-foreground"
                    >
                        {{ tech }}
                    </span>
                 </div>
            </div>

            <!-- Bottom CTA -->
            <div class="rounded-2xl bg-primary px-6 py-12 sm:p-16 text-center overflow-hidden relative">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-accent/10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-accent/10 blur-3xl"></div>
                
                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-2xl sm:text-3xl font-bold text-primary-foreground mb-6">
                        Want similar results for your {{ caseStudy.client_industry }} company?
                    </h2>
                    <p class="text-primary-foreground/80 mb-8 text-lg">
                        We specialize in solving high-stakes problems with custom software. Let's discuss your specific challenges.
                    </p>
                    
                    <Link 
                        href="/strategy-call" 
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-8 py-3 text-base font-semibold text-accent-foreground shadow-lg transition-transform hover:scale-105"
                    >
                        Book a Strategy Call
                        <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
            
        </div>
    </MainLayout>
</template>
