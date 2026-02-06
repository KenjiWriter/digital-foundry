<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Switch } from '@/Components/ui/switch';
import RoiRepeater from '@/Components/Admin/RoiRepeater.vue';
import TechStackInput from '@/Components/Admin/TechStackInput.vue';
import { ArrowLeft, Save, Loader2, Upload } from 'lucide-vue-next';

const props = defineProps<{
    caseStudy?: any;
}>();

const isEditing = !!props.caseStudy;

const form = useForm({
    title: props.caseStudy?.title || '',
    client_industry: props.caseStudy?.client_industry || '',
    challenge_summary: props.caseStudy?.challenge_summary || '',
    solution_summary: props.caseStudy?.solution_summary || '',
    roi_stats: props.caseStudy?.roi_stats || [],
    tech_stack: props.caseStudy?.tech_stack || [],
    is_published: props.caseStudy?.is_published || false,
    cover_image: null as File | null,
    _method: isEditing ? 'PUT' : 'POST',
});

// Declare global route function if needed, or just assume it exists
declare const route: any;

const imagePreview = ref(props.caseStudy?.cover_image_path ? `/storage/${props.caseStudy.cover_image_path}` : null);
const fileInput = ref<HTMLInputElement | null>(null);

const handleImageChange = (e: Event) => {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        form.cover_image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    if (isEditing) {
        form.post(route('admin.case-studies.update', props.caseStudy.id), {
            forceFormData: true,
        });
    } else {
        form.post(route('admin.case-studies.store'));
    }
};
</script>

<template>
    <AdminLayout :breadcrumbs="[{ title: 'Case Studies', href: route('admin.case-studies.index') }, { title: isEditing ? 'Edit' : 'Create', href: '#' }]">
        
        <div class="max-w-5xl mx-auto py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <Link :href="route('admin.case-studies.index')" class="p-2 rounded-full hover:bg-white/10 transition-colors">
                        <ArrowLeft class="h-6 w-6 text-gray-400" />
                    </Link>
                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white">{{ isEditing ? 'Edit Case Study' : 'New Case Study' }}</h1>
                        <p class="text-gray-400 text-sm">Showcase your success stories.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-900 border border-gray-800">
                        <Switch id="published" :checked="form.is_published" @update:checked="form.is_published = $event" />
                        <Label for="published" class="text-sm font-medium text-gray-300">Published</Label>
                    </div>
                    <Button @click="submit" :disabled="form.processing" class="bg-blue-600 hover:bg-blue-500 text-white font-bold">
                        <Loader2 v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" />
                        <Save v-else class="mr-2 h-4 w-4" />
                        {{ isEditing ? 'Update Results' : 'Launch Study' }}
                    </Button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Core Info -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Basic Info Card -->
                    <div class="p-6 rounded-xl bg-gray-900/40 border border-white/5 space-y-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <Label class="text-gray-300">Client / Title</Label>
                                <Input v-model="form.title" class="bg-black/50 border-white/10 text-white" placeholder="Global Logistics Co." />
                                <div v-if="form.errors.title" class="text-red-400 text-xs">{{ form.errors.title }}</div>
                            </div>
                            <div class="space-y-2">
                                <Label class="text-gray-300">Industry</Label>
                                <Input v-model="form.client_industry" class="bg-black/50 border-white/10 text-white" placeholder="Supply Chain" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <Label class="text-gray-300">The Challenge</Label>
                            <Textarea v-model="form.challenge_summary" rows="4" class="bg-black/50 border-white/10 text-white resize-none" placeholder="What was broken?" />
                        </div>

                        <div class="space-y-2">
                            <Label class="text-gray-300">The Solution</Label>
                            <Textarea v-model="form.solution_summary" rows="4" class="bg-black/50 border-white/10 text-white resize-none" placeholder="How did we fix it?" />
                        </div>
                    </div>

                    <!-- Tech Stack -->
                    <div class="p-6 rounded-xl bg-gray-900/40 border border-white/5">
                        <TechStackInput v-model="form.tech_stack" />
                    </div>

                </div>

                <!-- Right Column: Media & Stats -->
                <div class="space-y-8">
                    
                    <!-- Cover Image -->
                    <div class="p-6 rounded-xl bg-gray-900/40 border border-white/5 space-y-4">
                        <Label class="text-base font-semibold text-white">Cover Image</Label>
                        
                        <div 
                            class="relative aspect-video rounded-lg overflow-hidden border-2 border-dashed border-gray-700 bg-black/50 flex items-center justify-center group cursor-pointer hover:border-blue-500/50 transition-colors"
                            @click="fileInput?.click()"
                        >
                            <img v-if="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover" />
                            <div v-else class="text-center p-4">
                                <Upload class="h-8 w-8 text-gray-500 mx-auto mb-2" />
                                <p class="text-xs text-gray-500">Click to upload <br/> (Max 2MB)</p>
                            </div>
                            <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <p class="text-white text-sm font-medium">Change Image</p>
                            </div>
                        </div>
                        <input type="file" ref="fileInput" class="hidden" accept="image/*" @change="handleImageChange" />
                        <div v-if="form.errors.cover_image" class="text-red-400 text-xs">{{ form.errors.cover_image }}</div>
                    </div>

                    <!-- ROI Stats -->
                    <div class="p-6 rounded-xl bg-gray-900/40 border border-white/5">
                        <RoiRepeater v-model="form.roi_stats" />
                    </div>

                </div>
            </div>
        </div>
    </AdminLayout>
</template>
