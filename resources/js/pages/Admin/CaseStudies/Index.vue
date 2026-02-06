<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/Components/ui/button';
import { Badge } from '@/Components/ui/badge';
import { Plus, Edit, Trash2, Globe, EyeOff, LayoutTemplate } from 'lucide-vue-next';



defineProps<{
    caseStudies: any[];
}>();

const deleteCaseStudy = (id: number) => {
    if (confirm('Are you sure you want to delete this case study?')) {
    if (confirm('Are you sure you want to delete this case study?')) {
        router.delete(`/admin/case-studies/${id}`);
    }
    }
};
</script>

<template>
    <AdminLayout :breadcrumbs="[{ title: 'Case Studies', href: '#' }]">
        <div class="max-w-7xl mx-auto py-8">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-white">Case Studies</h1>
                    <p class="text-gray-400 text-sm mt-1">Manage your portfolio items.</p>
                </div>
                <Link href="/admin/case-studies/create">
                    <Button class="bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-500/20">
                        <Plus class="mr-2 h-4 w-4" /> New Case Study
                    </Button>
                </Link>
            </div>

            <!-- Empty State -->
            <div v-if="caseStudies.length === 0" class="text-center py-20 bg-gray-900/20 border border-dashed border-gray-800 rounded-2xl">
                <LayoutTemplate class="h-12 w-12 text-gray-600 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-white">No case studies yet</h3>
                <p class="text-gray-500 mb-6">Start by adding your first success story.</p>
                <Link href="/admin/case-studies/create">
                    <Button variant="outline">Create Now</Button>
                </Link>
            </div>

            <!-- List -->
            <div v-else class="grid grid-cols-1 gap-4">
                <div 
                    v-for="study in caseStudies" 
                    :key="study.id" 
                    class="group flex items-center gap-4 bg-[#111827] border border-gray-800 p-4 rounded-xl hover:border-gray-700 transition-colors"
                >
                    <!-- Thumbnail -->
                    <div class="h-16 w-24 rounded-lg bg-gray-800 overflow-hidden flex-shrink-0 border border-white/5">
                        <img v-if="study.cover_image_path" :src="`/storage/${study.cover_image_path}`" class="object-cover w-full h-full" />
                        <div v-else class="w-full h-full flex items-center justify-center text-gray-600">
                            <LayoutTemplate class="h-6 w-6" />
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-white font-semibold truncate">{{ study.title }}</h3>
                            <Badge :variant="study.is_published ? 'default' : 'secondary'" :class="study.is_published ? 'bg-green-500/10 text-green-400 hover:bg-green-500/20' : 'bg-gray-700 text-gray-400'">
                                {{ study.is_published ? 'Published' : 'Draft' }}
                            </Badge>
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ study.client_industry }}</p>
                    </div>

                    <!-- Stats Preview -->
                    <div class="hidden md:flex gap-4 px-8 border-l border-r border-gray-800/50">
                        <div class="text-center">
                            <div class="text-lg font-bold text-white">{{ study.roi_stats?.length || 0 }}</div>
                            <div class="text-[10px] uppercase tracking-wider text-gray-500">Metrics</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-white">{{ study.tech_stack?.length || 0 }}</div>
                            <div class="text-[10px] uppercase tracking-wider text-gray-500">Technologies</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <Link :href="`/admin/case-studies/${study.id}/edit`">
                            <Button variant="ghost" size="icon" class="text-gray-400 hover:text-white hover:bg-white/10">
                                <Edit class="h-4 w-4" />
                            </Button>
                        </Link>
                        <Button 
                            variant="ghost" 
                            size="icon" 
                            class="text-gray-600 hover:text-red-400 hover:bg-red-400/10"
                            @click="deleteCaseStudy(study.id)"
                        >
                            <Trash2 class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>
