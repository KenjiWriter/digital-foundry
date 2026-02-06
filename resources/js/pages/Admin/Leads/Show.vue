<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ArrowLeft, Mail, Globe, MapPin, Calendar, Clock, Trash2 } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
    lead: {
        id: number;
        name: string;
        email: string;
        website: string | null;
        message: string;
        ip_address: string | null;
        created_at: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Leads',
        href: '/admin/leads',
    },
    {
        title: props.lead.name,
        href: `/admin/leads/${props.lead.id}`,
    },
];

const deleteLead = () => {
    if (confirm('Are you sure you want to delete this lead?')) {
        router.delete(`/admin/leads/${props.lead.id}`);
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleString();
};
</script>

<template>
    <Head :title="`Lead: ${lead.name}`" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-4 max-w-4xl">
            
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link href="/admin/leads" class="p-2 rounded-lg bg-gray-800 text-gray-400 hover:text-white transition-colors">
                        <ArrowLeft class="h-5 w-5" />
                    </Link>
                    <h1 class="text-2xl font-bold text-white">{{ lead.name }}</h1>
                </div>
                <button @click="deleteLead" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500/20 transition-colors">
                    <Trash2 class="h-4 w-4" />
                    <span class="text-sm font-medium">Delete Lead</span>
                </button>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                
                <!-- Main Content: Message -->
                <div class="md:col-span-2 space-y-6">
                    <div class="rounded-xl border border-gray-800 bg-[#111827] p-6">
                        <h2 class="text-lg font-semibold text-white mb-4">Message</h2>
                        <div class="prose prose-invert max-w-none text-gray-300 whitespace-pre-wrap leading-relaxed">
                            {{ lead.message }}
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Details -->
                <div class="space-y-6">
                    <div class="rounded-xl border border-gray-800 bg-[#111827] p-6 space-y-4">
                        <h2 class="text-lg font-semibold text-white mb-2">Contact Details</h2>
                        
                        <!-- Email -->
                        <div class="space-y-1">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</span>
                            <div class="flex items-center gap-2 text-gray-200">
                                <Mail class="h-4 w-4 text-gray-400" />
                                <a :href="`mailto:${lead.email}`" class="hover:text-blue-400 transition-colors">{{ lead.email }}</a>
                            </div>
                        </div>

                        <!-- Website -->
                        <div v-if="lead.website" class="space-y-1">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Website</span>
                            <div class="flex items-center gap-2 text-gray-200">
                                <Globe class="h-4 w-4 text-gray-400" />
                                <a :href="lead.website" target="_blank" class="hover:text-blue-400 transition-colors break-all">{{ lead.website }}</a>
                            </div>
                        </div>

                        <!-- IP Address -->
                        <div v-if="lead.ip_address" class="space-y-1">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</span>
                            <div class="flex items-center gap-2 text-gray-400">
                                <MapPin class="h-4 w-4" />
                                {{ lead.ip_address }}
                            </div>
                        </div>

                         <!-- Date -->
                        <div class="space-y-1 pt-4 border-t border-gray-800">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Received At</span>
                            <div class="flex items-center gap-2 text-gray-400">
                                <Clock class="h-4 w-4" />
                                {{ formatDate(lead.created_at) }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </AdminLayout>
</template>
