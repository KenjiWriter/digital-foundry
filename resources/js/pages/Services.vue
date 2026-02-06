<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTrans } from '@/composables/useTrans';
import { Database, BarChart3, Code, Shield, CheckCircle, XCircle } from 'lucide-vue-next';

const { trans } = useTrans();
</script>

<template>
    <Head title="Usługi Programistyczne & Audyt IT | Cerasus Digital">
        <meta name="description" content="Oferujemy budowę systemów CRM/ERP, audyty kodu oraz przejmowanie projektów (Rescue Projects). Sprawdź naszą ofertę B2B.">
    </Head>

    <MainLayout>
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-900 py-24 overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:14px_24px]"></div>
            </div>
            
            <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                        {{ trans('services.hero.title') }}
                    </h1>
                    <p class="text-xl text-slate-300 leading-relaxed">
                        {{ trans('services.hero.subtitle') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Custom vs SaaS Comparison Section -->
        <section class="bg-slate-900 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-5xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                            {{ trans('services.comparison.title') }}
                        </h2>
                        <p class="text-lg text-slate-400">
                            {{ trans('services.comparison.subtitle') }}
                        </p>
                    </div>

                    <!-- Key Arguments -->
                    <div class="mb-12 space-y-6">
                        <div class="bg-slate-800/50 border border-amber-500/20 rounded-lg p-6">
                            <p class="text-slate-200 text-lg leading-relaxed">
                                {{ trans('services.comparison.custom') }}
                            </p>
                        </div>
                        <div class="bg-slate-800/50 border border-amber-500/20 rounded-lg p-6">
                            <p class="text-amber-400 text-lg font-semibold leading-relaxed">
                                💰 {{ trans('services.comparison.financial') }}
                            </p>
                        </div>
                    </div>

                    <!-- Comparison Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Custom System -->
                        <div class="bg-gradient-to-br from-emerald-900/30 to-slate-900/50 border border-emerald-500/30 rounded-xl p-8">
                            <div class="flex items-center justify-center mb-6">
                                <div class="bg-emerald-500/20 rounded-full p-4">
                                    <CheckCircle class="w-8 h-8 text-emerald-400" />
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-emerald-400 mb-6 text-center">
                                {{ trans('services.comparison.title').split('vs')[0].trim() }}
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="text-sm font-semibold text-emerald-300 mb-1">
                                        {{ trans('services.comparison.ownership') }}
                                    </div>
                                    <div class="text-slate-200">
                                        {{ trans('services.comparison.ownership_custom') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-emerald-300 mb-1">
                                        {{ trans('services.comparison.flexibility') }}
                                    </div>
                                    <div class="text-slate-200">
                                        {{ trans('services.comparison.flexibility_custom') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-emerald-300 mb-1">
                                        {{ trans('services.comparison.cost') }}
                                    </div>
                                    <div class="text-slate-200">
                                        {{ trans('services.comparison.cost_custom') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-emerald-300 mb-1">
                                        {{ trans('services.comparison.data') }}
                                    </div>
                                    <div class="text-slate-200">
                                        {{ trans('services.comparison.data_custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SaaS -->
                        <div class="bg-gradient-to-br from-red-900/20 to-slate-900/50 border border-red-500/20 rounded-xl p-8 opacity-75">
                            <div class="flex items-center justify-center mb-6">
                                <div class="bg-red-500/20 rounded-full p-4">
                                    <XCircle class="w-8 h-8 text-red-400" />
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-red-400 mb-6 text-center">
                                {{ trans('services.comparison.title').split('vs')[1].trim() }}
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="text-sm font-semibold text-red-300 mb-1">
                                        {{ trans('services.comparison.ownership') }}
                                    </div>
                                    <div class="text-slate-300">
                                        {{ trans('services.comparison.ownership_saas') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-red-300 mb-1">
                                        {{ trans('services.comparison.flexibility') }}
                                    </div>
                                    <div class="text-slate-300">
                                        {{ trans('services.comparison.flexibility_saas') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-red-300 mb-1">
                                        {{ trans('services.comparison.cost') }}
                                    </div>
                                    <div class="text-slate-300">
                                        {{ trans('services.comparison.cost_saas') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-red-300 mb-1">
                                        {{ trans('services.comparison.data') }}
                                    </div>
                                    <div class="text-slate-300">
                                        {{ trans('services.comparison.data_saas') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Services Section -->
        <section class="bg-slate-950 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-12 text-center">
                        {{ trans('services.core.title') }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Service 1: Custom Development -->
                        <div class="group bg-slate-900 border border-slate-800 rounded-xl p-8 hover:border-amber-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-amber-500/10">
                            <div class="bg-gradient-to-br from-amber-500/20 to-amber-600/10 rounded-lg p-4 w-fit mb-6 group-hover:scale-110 transition-transform duration-300">
                                <Code class="w-8 h-8 text-amber-400" />
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4">
                                {{ trans('services.core.service1_title') }}
                            </h3>
                            <p class="text-slate-400 leading-relaxed">
                                {{ trans('services.core.service1_desc') }}
                            </p>
                        </div>

                        <!-- Service 2: Analytics & BI -->
                        <div class="group bg-slate-900 border border-slate-800 rounded-xl p-8 hover:border-amber-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-amber-500/10">
                            <div class="bg-gradient-to-br from-amber-500/20 to-amber-600/10 rounded-lg p-4 w-fit mb-6 group-hover:scale-110 transition-transform duration-300">
                                <BarChart3 class="w-8 h-8 text-amber-400" />
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4">
                                {{ trans('services.core.service2_title') }}
                            </h3>
                            <p class="text-slate-400 leading-relaxed">
                                {{ trans('services.core.service2_desc') }}
                            </p>
                        </div>

                        <!-- Service 3: Audit & Consulting -->
                        <div class="group bg-slate-900 border border-slate-800 rounded-xl p-8 hover:border-amber-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-amber-500/10">
                            <div class="bg-gradient-to-br from-amber-500/20 to-amber-600/10 rounded-lg p-4 w-fit mb-6 group-hover:scale-110 transition-transform duration-300">
                                <Shield class="w-8 h-8 text-amber-400" />
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4">
                                {{ trans('services.core.service3_title') }}
                            </h3>
                            <p class="text-slate-400 leading-relaxed">
                                {{ trans('services.core.service3_desc') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tech Stack Section -->
        <section class="bg-slate-900 py-20">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                            {{ trans('services.tech.title') }}
                        </h2>
                        <p class="text-lg text-slate-400">
                            {{ trans('services.tech.subtitle') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Laravel -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 text-center">
                            <div class="bg-red-500/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <Database class="w-8 h-8 text-red-400" />
                            </div>
                            <p class="text-slate-200 font-medium">
                                {{ trans('services.tech.laravel') }}
                            </p>
                        </div>

                        <!-- Vue -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 text-center">
                            <div class="bg-emerald-500/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <Code class="w-8 h-8 text-emerald-400" />
                            </div>
                            <p class="text-slate-200 font-medium">
                                {{ trans('services.tech.vue') }}
                            </p>
                        </div>

                        <!-- Tailwind -->
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6 text-center">
                            <div class="bg-cyan-500/10 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <Shield class="w-8 h-8 text-cyan-400" />
                            </div>
                            <p class="text-slate-200 font-medium">
                                {{ trans('services.tech.tailwind') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-b from-slate-950 to-slate-900 py-24">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-8">
                        {{ trans('services.cta.title') }}
                    </h2>
                    <Link 
                        href="/#contact" 
                        class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-slate-900 bg-gradient-to-r from-amber-400 to-amber-500 rounded-lg shadow-lg hover:shadow-amber-500/50 hover:scale-105 transition-all duration-300"
                    >
                        {{ trans('services.cta.button') }}
                    </Link>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
