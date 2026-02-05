<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import CaseStudyCard from '@/Components/CaseStudyCard.vue';

interface CaseStudy {
    id: number;
    title: string;
    client_industry: string;
    cover_image_path: string;
    challenge_summary: string;
    roi_stats: Record<string, string>;
    tech_stack: string[];
}

defineProps<{
    caseStudies: CaseStudy[];
}>();
</script>

<template>
    <Head title="Our Work - Proven Results" />

    <MainLayout>
        <!-- Page Header -->
        <div class="bg-background border-b border-border py-16 sm:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-bold tracking-tight text-foreground sm:text-5xl mb-4">
                    Proven Results in Code
                </h1>
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                    Real-world examples of how we've helped businesses automate workflows, reduce errors, and increase revenue.
                </p>
            </div>
        </div>

        <!-- Grid Section -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <CaseStudyCard 
                    v-for="study in caseStudies" 
                    :key="study.id" 
                    :case-study="study" 
                />
            </div>
            
            <!-- Empty State -->
            <div v-if="caseStudies.length === 0" class="text-center py-20">
                <p class="text-muted-foreground">No case studies published yet.</p>
            </div>
        </div>
    </MainLayout>
</template>
