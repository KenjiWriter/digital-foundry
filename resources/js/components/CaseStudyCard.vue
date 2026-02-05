<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ArrowUpRight, Flame } from 'lucide-vue-next';

interface CaseStudy {
    id: number;
    title: string;
    client_industry: string;
    cover_image_path: string;
    challenge_summary: string;
    roi_stats: Record<string, string>;
    tech_stack: string[];
}

const props = defineProps<{
    caseStudy: CaseStudy;
}>();

// Extract the first ROI stat for the "Money" section
const primaryRoi = computed(() => {
    const keys = Object.keys(props.caseStudy.roi_stats);
    if (keys.length === 0) return null;
    const key = keys[0];
    return { label: key, value: props.caseStudy.roi_stats[key] };
});

const displayedTech = computed(() => props.caseStudy.tech_stack.slice(0, 3));
</script>

<template>
    <div class="group relative flex flex-col overflow-hidden rounded-xl border border-border bg-card transition-all hover:shadow-lg hover:shadow-primary/5">
        <!-- Image Section -->
        <div class="relative aspect-video overflow-hidden bg-muted">
            <img 
                :src="caseStudy.cover_image_path" 
                :alt="caseStudy.title" 
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
            
            <!-- Industry Badge -->
            <div class="absolute top-4 left-4">
                <span class="inline-flex items-center rounded-full bg-background/90 px-2.5 py-0.5 text-xs font-medium text-foreground backdrop-blur-sm">
                    {{ caseStudy.client_industry }}
                </span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex flex-1 flex-col p-6">
            <h3 class="mb-2 text-xl font-bold leading-tight tracking-tight text-foreground group-hover:text-primary transition-colors">
                <Link :href="`/case-studies/${caseStudy.id}`">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    {{ caseStudy.title }}
                </Link>
            </h3>
            
            <p class="mb-6 line-clamp-2 text-sm text-muted-foreground">
                {{ caseStudy.challenge_summary }}
            </p>

            <!-- The "Money" Section -->
            <div v-if="primaryRoi" class="mb-6 mt-auto">
                <div class="inline-flex items-center gap-2 rounded-lg bg-accent/10 px-3 py-2 text-sm font-semibold text-accent border border-accent/20">
                    <Flame class="h-4 w-4" />
                    <span>{{ primaryRoi.label }}: {{ primaryRoi.value }}</span>
                </div>
            </div>

            <div class="mt-auto flex items-center justify-between border-t border-border pt-4">
                <!-- Tech Stack -->
                <div class="flex gap-2">
                    <span 
                        v-for="tech in displayedTech" 
                        :key="tech"
                        class="text-xs font-medium text-muted-foreground bg-muted px-2 py-1 rounded"
                    >
                        {{ tech }}
                    </span>
                </div>

                <!-- Arrow Icon -->
                <ArrowUpRight class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1 group-hover:-translate-y-1 group-hover:text-primary" />
            </div>
        </div>
    </div>
</template>
