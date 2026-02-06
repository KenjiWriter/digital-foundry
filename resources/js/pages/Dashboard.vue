<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Folder, ArrowRight, BarChart } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

// Declare route helper
declare const route: any;
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            
            <!-- Welcome Banner -->
            <div class="rounded-xl border border-gray-800 bg-[#111827] p-8 shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white mb-2">Welcome back, Admin.</h2>
                    <p class="text-gray-400 max-w-xl">
                        This is your Control Room. Manage your portfolio, track leads, and update case studies from a single secure interface.
                    </p>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                
                <!-- Manage Case Studies Card -->
                <Link :href="route('admin.case-studies.index')" class="group relative overflow-hidden rounded-xl border border-gray-800 bg-[#111827] p-6 transition-all hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 rounded-lg bg-blue-500/10 text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <Folder class="h-6 w-6" />
                        </div>
                        <h3 class="text-lg font-semibold text-white">Manage Case Studies</h3>
                    </div>
                    <p class="text-sm text-gray-400 mb-4">Add new success stories, update ROI metrics, and publish drafts.</p>
                    <div class="flex items-center text-sm font-medium text-blue-400 group-hover:text-blue-300">
                        Go to Manager <ArrowRight class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                    </div>
                </Link>

                <!-- Analytics / Placeholder -->
                <div class="relative overflow-hidden rounded-xl border border-gray-800 bg-[#111827]/50 p-6 opacity-75">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 rounded-lg bg-gray-800 text-gray-400">
                            <BarChart class="h-6 w-6" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-300">Traffic Analytics</h3>
                    </div>
                    <p class="text-sm text-gray-500">Coming soon directly to your dashboard.</p>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>

