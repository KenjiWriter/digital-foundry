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

const props = defineProps<{
    stats?: Array<{
        date: string;
        visits: number;
        page_views: number;
    }>;
}>();

import { computed } from 'vue';

const stats = computed(() => props.stats || []);

const maxVisits = computed(() => {
    if (stats.value.length === 0) return 1;
    return Math.max(...stats.value.map(s => s.visits));
});

const totalVisits = computed(() => {
    return stats.value.reduce((acc, curr) => acc + curr.visits, 0);
});

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
                <Link href="/admin/case-studies" class="group relative overflow-hidden rounded-xl border border-gray-800 bg-[#111827] p-6 transition-all hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10">
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

                <!-- Analytics Chart -->
                <div class="relative overflow-hidden rounded-xl border border-gray-800 bg-[#111827] p-6 col-span-2 md:col-span-1">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-lg bg-green-500/10 text-green-400">
                                <BarChart class="h-6 w-6" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Traffic Overview</h3>
                                <p class="text-sm text-gray-400">Last 30 Days</p>
                            </div>
                        </div>
                        <div class="text-right">
                             <div class="text-2xl font-bold text-white">{{ totalVisits }}</div>
                             <div class="text-xs text-gray-500 uppercase tracking-wider">Total Visits</div>
                        </div>
                    </div>

                    <!-- SVG Chart -->
                    <div class="h-32 w-full flex items-end gap-1">
                        <div 
                            v-for="(stat, index) in stats" 
                            :key="index"
                            class="relative flex-1 group"
                            :title="`${stat.date}: ${stat.visits} visits`"
                        >
                            <div 
                                class="w-full bg-green-500/20 hover:bg-green-500/40 transition-colors rounded-t-sm"
                                :style="{ height: `${(stat.visits / maxVisits) * 100}%` }"
                            ></div>
                             <!-- Tooltip (SimpleCSS) -->
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10 border border-gray-700">
                                {{ stat.date }}: {{ stat.visits }}
                            </div>
                        </div>
                         <div v-if="stats.length === 0" class="w-full h-full flex items-center justify-center text-gray-500 text-sm">
                            No data yet.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>

