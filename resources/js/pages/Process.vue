<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTrans } from '@/composables/useTrans';
import { 
    Clipboard, 
    MessageCircle, 
    BarChart3, 
    Handshake, 
    Rocket, 
    CheckCircle2, 
    Sparkles 
} from 'lucide-vue-next';

const { trans } = useTrans();

const steps = [
    {
        number: 1,
        icon: Clipboard,
        titleKey: 'process.step1_title',
        subtitleKey: 'process.step1_subtitle',
        descKey: 'process.step1_desc',
    },
    {
        number: 2,
        icon: MessageCircle,
        titleKey: 'process.step2_title',
        subtitleKey: 'process.step2_subtitle',
        descKey: 'process.step2_desc',
    },
    {
        number: 3,
        icon: BarChart3,
        titleKey: 'process.step3_title',
        subtitleKey: 'process.step3_subtitle',
        descKey: 'process.step3_desc',
    },
    {
        number: 4,
        icon: Handshake,
        titleKey: 'process.step4_title',
        subtitleKey: 'process.step4_subtitle',
        descKey: 'process.step4_desc',
    },
    {
        number: 5,
        icon: Rocket,
        titleKey: 'process.step5_title',
        subtitleKey: 'process.step5_subtitle',
        descKey: 'process.step5_desc',
    },
    {
        number: 6,
        icon: CheckCircle2,
        titleKey: 'process.step6_title',
        subtitleKey: 'process.step6_subtitle',
        descKey: 'process.step6_desc',
    },
    {
        number: 7,
        icon: Sparkles,
        titleKey: 'process.step7_title',
        subtitleKey: 'process.step7_subtitle',
        descKey: 'process.step7_desc',
    },
];
</script>

<template>
    <Head title="Jak pracujemy? Proces Wdrożenia | Cerasus Digital">
        <meta name="description" content="Od warsztatu po wdrożenie. Zobacz, jak bezpiecznie i terminowo dostarczamy oprogramowanie klasy Enterprise.">
        <link rel="canonical" :href="($page.props.url as string)" />
    </Head>

    <MainLayout>
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-b from-slate-900 via-slate-800 to-[#020617] py-20 sm:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-accent/10 px-4 py-2 text-sm font-medium text-accent border border-accent/20">
                        <Sparkles class="h-4 w-4" />
                        <span>Our Methodology</span>
                    </div>
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                        {{ trans('process.header') }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="relative bg-[#020617] py-16 sm:py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-4xl">
                    <div class="relative">
                        <!-- Vertical Timeline Line -->
                        <div 
                            class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-accent via-accent/50 to-transparent hidden sm:block"
                            aria-hidden="true"
                        />

                        <!-- Steps -->
                        <div class="space-y-12">
                            <div 
                                v-for="(step, index) in steps" 
                                :key="step.number"
                                class="relative group"
                            >
                                <div class="flex gap-6 sm:gap-8">
                                    <!-- Icon Circle (Timeline Node) -->
                                    <div class="flex-shrink-0">
                                        <div 
                                            class="relative z-10 flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-accent to-accent/80 shadow-lg shadow-accent/30 transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-accent/50"
                                        >
                                            <component 
                                                :is="step.icon" 
                                                class="h-7 w-7 text-accent-foreground" 
                                            />
                                        </div>
                                    </div>

                                    <!-- Content Card -->
                                    <div 
                                        class="flex-1 pb-12 pt-2"
                                        :class="{ 'pb-0': index === steps.length - 1 }"
                                    >
                                        <div 
                                            class="relative overflow-hidden rounded-xl border border-border bg-card/50 backdrop-blur-sm p-6 transition-all duration-300 hover:border-accent/50 hover:bg-card/70 hover:shadow-lg hover:shadow-accent/10"
                                        >
                                            <!-- Step Number Badge -->
                                            <div class="absolute top-4 right-4 flex h-8 w-8 items-center justify-center rounded-full bg-accent/10 text-sm font-bold text-accent">
                                                {{ step.number }}
                                            </div>

                                            <!-- Title & Subtitle -->
                                            <div class="mb-3 pr-12">
                                                <h3 class="text-xl font-bold text-foreground sm:text-2xl">
                                                    {{ trans(step.titleKey) }}
                                                </h3>
                                                <p class="mt-1 text-sm font-medium text-accent uppercase tracking-wide">
                                                    {{ trans(step.subtitleKey) }}
                                                </p>
                                            </div>

                                            <!-- Description -->
                                            <p class="text-muted-foreground leading-relaxed">
                                                {{ trans(step.descKey) }}
                                            </p>

                                            <!-- Decorative Gradient -->
                                            <div 
                                                class="absolute -bottom-px left-0 right-0 h-px bg-gradient-to-r from-transparent via-accent/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative bg-gradient-to-t from-slate-900 via-[#020617] to-[#020617] py-16 sm:py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl mb-4">
                        {{ trans('process.cta_text') }}
                    </h2>
                    <a 
                        href="/#contact"
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-lg bg-accent px-8 py-3 text-base font-semibold text-accent-foreground shadow-lg shadow-accent/30 transition-all duration-300 hover:bg-accent/90 hover:scale-105 hover:shadow-xl hover:shadow-accent/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2 focus-visible:ring-offset-background"
                    >
                        {{ trans('process.cta_button') }}
                        <Rocket class="h-5 w-5" />
                    </a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
