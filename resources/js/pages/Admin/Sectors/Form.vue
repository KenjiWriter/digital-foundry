<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Switch } from '@/Components/ui/switch';
import { ArrowLeft, Save, Loader2, Info } from 'lucide-vue-next';
import QuestionsRepeater from '@/Components/Admin/QuestionsRepeater.vue';

const props = defineProps<{
    sector?: any;
}>();

const isEditing = !!props.sector;

const form = useForm({
    name: {
        en: props.sector?.name?.en || '',
        pl: props.sector?.name?.pl || '',
    },
    icon: props.sector?.icon || '',
    is_active: props.sector?.is_active ?? true,
    questions: props.sector?.questions || [],
});

const submit = () => {
    if (isEditing) {
        form.put(`/admin/sectors/${props.sector.id}`);
    } else {
        form.post('/admin/sectors');
    }
};
</script>

<template>
    <AdminLayout :breadcrumbs="[{ title: 'Sectors', href: '/admin/sectors' }, { title: isEditing ? 'Edit' : 'Create', href: '#' }]">
        
        <div class="max-w-5xl mx-auto py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <Link href="/admin/sectors" class="p-2 rounded-full hover:bg-white/10 transition-colors">
                        <ArrowLeft class="h-6 w-6 text-gray-400" />
                    </Link>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">{{ isEditing ? `Edit ${form.name.en}` : 'New Sector' }}</h1>
                        <p class="text-gray-400 text-sm">Define an industry vertical and its audit questions.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <Button @click="submit" :disabled="form.processing" class="bg-blue-600 hover:bg-blue-500 text-white font-bold">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        <Save v-else class="mr-2 h-4 w-4" />
                        {{ isEditing ? 'Update Sector' : 'Create Sector' }}
                    </Button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Core Info -->
                <div class="space-y-8">
                    <div class="p-6 rounded-xl bg-gray-900/40 border border-white/5 space-y-6">
                        <div class="flex items-center justify-between">
                            <Label class="text-base font-semibold text-white">Basic Info</Label>
                            <div class="flex items-center gap-2">
                                <Label for="active" class="text-sm font-medium text-gray-300">Active</Label>
                                <Switch id="active" :checked="form.is_active" @update:checked="form.is_active = $event" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-2">
                                <Label class="text-gray-300">Sector Name (EN)</Label>
                                <Input v-model="form.name.en" class="bg-black/50 border-white/10 text-white" placeholder="Logistics" />
                            </div>
                            <div class="space-y-2">
                                <Label class="text-gray-300">Sector Name (PL)</Label>
                                <Input v-model="form.name.pl" class="bg-black/50 border-white/10 text-white" placeholder="Logistyka" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <Label class="text-gray-300">Icon Name</Label>
                                <a href="https://lucide.dev/icons" target="_blank" class="text-xs text-blue-400 hover:underline flex items-center">
                                    <Info class="w-3 h-3 mr-1" />
                                    Lucide Library
                                </a>
                            </div>
                            <Input v-model="form.icon" class="bg-black/50 border-white/10 text-white" placeholder="Truck" />
                            <p class="text-xs text-gray-500">Exact name from Lucide Icons (e.g. Truck, Briefcase)</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Questions -->
                <div class="lg:col-span-2 space-y-8">
                     <QuestionsRepeater v-model="form.questions" />
                     <div v-if="form.errors.questions" class="text-red-400 text-sm">{{ form.errors.questions }}</div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
