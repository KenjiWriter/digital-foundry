<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { Link } from '@inertiajs/vue3';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table';
import { Edit, Truck, ShoppingBag, Briefcase, Activity, Globe } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    sectors: any[];
}>();

// Simple icon mapper - in a real app might want a more robust way
const getIcon = (name: string) => {
    switch (name) {
        case 'Truck': return Truck;
        case 'ShoppingBag': return ShoppingBag;
        case 'Briefcase': return Briefcase;
        default: return Activity;
    }
};
</script>

<template>
    <AdminLayout :breadcrumbs="[{ title: 'Sectors', href: '/admin/sectors' }]">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white mb-2">Business Sectors</h1>
                    <p class="text-gray-400">Manage audit scenarios and questions.</p>
                </div>
                <Link href="/admin/sectors/create">
                    <Button class="bg-blue-600 hover:bg-blue-500 text-white">
                        Add New Sector
                    </Button>
                </Link>
            </div>

            <Card class="bg-gray-900 border-gray-800">
                <CardContent class="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow class="border-gray-800 hover:bg-transparent">
                                <TableHead class="text-gray-400">Icon</TableHead>
                                <TableHead class="text-gray-400">Name (EN / PL)</TableHead>
                                <TableHead class="text-gray-400">Questions</TableHead>
                                <TableHead class="text-gray-400">Status</TableHead>
                                <TableHead class="text-right text-gray-400">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="sector in sectors" :key="sector.id" class="border-gray-800 hover:bg-white/5 transition-colors">
                                <TableCell>
                                    <div class="p-2 bg-gray-800 rounded-lg w-fit text-blue-400">
                                        <component :is="getIcon(sector.icon)" class="w-5 h-5" />
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-col">
                                        <span class="text-white font-medium">{{ sector.name.en }}</span>
                                        <span class="text-gray-500 text-xs">{{ sector.name.pl }}</span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <Badge variant="outline" class="bg-gray-800 border-gray-700 text-gray-300">
                                        {{ sector.questions_count }} Questions
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <Badge :variant="sector.is_active ? 'default' : 'destructive'" :class="sector.is_active ? 'bg-green-900/50 text-green-400 hover:bg-green-900/50' : ''">
                                        {{ sector.is_active ? 'Active' : 'Inactive' }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <Link :href="`/admin/sectors/${sector.id}/edit`">
                                        <Button variant="ghost" size="icon" class="hover:bg-blue-900/20 text-blue-400">
                                            <Edit class="w-4 h-4" />
                                        </Button>
                                    </Link>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AdminLayout>
</template>
