<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Mail, Calendar, Eye, Trash2 } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

defineProps<{
    leads: {
        data: Array<{
            id: number;
            name: string;
            email: string;
            website: string | null;
            message: string;
            created_at: string;
        }>;
        links: any[];
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Leads',
        href: '/admin/leads',
    },
];

const deleteLead = (id: number) => {
    if (confirm('Are you sure you want to delete this lead?')) {
        router.delete(`/admin/leads/${id}`, {
            preserveScroll: true,
        });
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString();
};
</script>

<template>
    <Head title="Leads" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Leads</h1>
            </div>

            <!-- Leads Table -->
            <div class="rounded-xl border border-gray-800 bg-[#111827] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-400">
                        <thead class="bg-gray-800/50 text-xs uppercase text-gray-300">
                            <tr>
                                <th class="px-6 py-4 font-medium">Name</th>
                                <th class="px-6 py-4 font-medium">Email</th>
                                <th class="px-6 py-4 font-medium">Website</th>
                                <th class="px-6 py-4 font-medium">Date</th>
                                <th class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            <tr v-for="lead in leads.data" :key="lead.id" class="hover:bg-gray-800/30 transition-colors">
                                <td class="px-6 py-4 font-medium text-white">{{ lead.name }}</td>
                                <td class="px-6 py-4">{{ lead.email }}</td>
                                <td class="px-6 py-4">
                                    <a v-if="lead.website" :href="lead.website" target="_blank" class="text-blue-400 hover:underline">
                                        {{ lead.website }}
                                    </a>
                                    <span v-else>-</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <Calendar class="h-3 w-3" />
                                        {{ formatDate(lead.created_at) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <Link :href="`/admin/leads/${lead.id}`" class="text-gray-400 hover:text-white transition-colors" title="View Details">
                                            <Eye class="h-4 w-4" />
                                        </Link>
                                        <button @click="deleteLead(lead.id)" class="text-red-500 hover:text-red-400 transition-colors" title="Delete">
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="leads.data.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <Mail class="h-8 w-8 mx-auto mb-3 opacity-50" />
                                    No leads found yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination (Simple) -->
            <div v-if="leads.links && leads.links.length > 3" class="flex justify-center mt-4">
                <div class="flex gap-1">
                     <Link
                        v-for="(link, i) in leads.links"
                        :key="i"
                        :href="link.url || '#'"
                        class="px-3 py-1 rounded text-sm"
                        :class="[
                            link.active ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:bg-gray-700',
                            !link.url && 'opacity-50 cursor-not-allowed'
                        ]"
                        v-html="link.label"
                    />
                </div>
            </div>

        </div>
    </AdminLayout>
</template>
