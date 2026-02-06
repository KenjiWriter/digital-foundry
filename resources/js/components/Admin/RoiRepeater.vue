<script setup lang="ts">
import { ref, watch } from 'vue';
import { Plus, X, ListPlus } from 'lucide-vue-next';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';

interface RoiStat {
    label: string;
    value: string;
}

const props = defineProps<{
    modelValue: RoiStat[] | null;
}>();

const emit = defineEmits(['update:modelValue']);

// Local state to handle input before emitting
const stats = ref<RoiStat[]>(props.modelValue ? [...props.modelValue] : []);

// Sync from props if external change (e.g. form reset)
watch(() => props.modelValue, (newVal) => {
    if (newVal) {
        stats.value = [...newVal];
    } else {
        stats.value = [];
    }
}, { deep: true });

const addStat = () => {
    stats.value.push({ label: '', value: '' });
    emitChange();
};

const removeStat = (index: number) => {
    stats.value.splice(index, 1);
    emitChange();
};

const emitChange = () => {
    emit('update:modelValue', stats.value);
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label class="text-base font-semibold text-white flex items-center gap-2">
                <ListPlus class="h-4 w-4 text-blue-400" />    
                ROI Metrics
            </Label>
            <Button 
                type="button" 
                variant="outline" 
                size="sm" 
                @click="addStat"
                class="border-blue-500/30 text-blue-400 hover:bg-blue-500/10 hover:text-blue-300"
            >
                <Plus class="mr-2 h-4 w-4" /> Add Metric
            </Button>
        </div>

        <div v-if="stats.length === 0" class="text-sm text-gray-500 italic p-4 border border-dashed border-gray-800 rounded-lg text-center">
            No metrics added yet. Click "Add Metric" to showcase results.
        </div>

        <div v-for="(stat, index) in stats" :key="index" class="flex gap-4 items-start group">
            <div class="grid flex-1 gap-2 grid-cols-2">
                <div>
                    <Label class="text-xs text-gray-500 mb-1.5 block">Label (e.g. Cost Reduced)</Label>
                    <Input 
                        v-model="stat.label" 
                        @input="emitChange"
                        placeholder="Label" 
                        class="bg-gray-900/50 border-gray-800 focus:border-blue-500/50"
                    />
                </div>
                <div>
                    <Label class="text-xs text-gray-500 mb-1.5 block">Value (e.g. 40%)</Label>
                    <Input 
                        v-model="stat.value" 
                        @input="emitChange"
                        placeholder="Value" 
                        class="bg-gray-900/50 border-gray-800 focus:border-blue-500/50"
                    />
                </div>
            </div>
            <Button 
                type="button"
                variant="ghost" 
                size="icon" 
                class="mt-6 text-gray-500 hover:text-red-400 hover:bg-red-400/10"
                @click="removeStat(index)"
            >
                <X class="h-4 w-4" />
            </Button>
        </div>
    </div>
</template>
