<script setup lang="ts">
import { ref, watch, nextTick } from 'vue';
import { X, Code2 } from 'lucide-vue-next';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';

const props = defineProps<{
    modelValue: string[] | null;
}>();

const emit = defineEmits(['update:modelValue']);

const tags = ref<string[]>(props.modelValue ? [...props.modelValue] : []);
const inputValue = ref('');

watch(() => props.modelValue, (newVal) => {
    if (newVal) {
        tags.value = [...newVal];
    } else {
        tags.value = [];
    }
}, { deep: true });

const addTag = () => {
    const val = inputValue.value.trim();
    if (val && !tags.value.includes(val)) {
        tags.value.push(val);
        emit('update:modelValue', tags.value);
    }
    inputValue.value = '';
};

const removeTag = (index: number) => {
    tags.value.splice(index, 1);
    emit('update:modelValue', tags.value);
};

const handleKeydown = (e: KeyboardEvent) => {
    if (e.key === 'Backspace' && inputValue.value === '' && tags.value.length > 0) {
        removeTag(tags.value.length - 1);
    }
};
</script>

<template>
    <div class="space-y-4">
        <Label class="text-base font-semibold text-white flex items-center gap-2">
            <Code2 class="h-4 w-4 text-purple-400" />    
            Tech Stack
        </Label>
        
        <div class="flex flex-wrap gap-2 p-3 bg-gray-900/50 border border-gray-800 rounded-lg min-h-[3rem] items-center focus-within:ring-1 focus-within:ring-purple-500/50 focus-within:border-purple-500/50 transition-all">
            <span 
                v-for="(tag, index) in tags" 
                :key="index"
                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-300 text-sm border border-purple-500/20"
            >
                {{ tag }}
                <button type="button" @click="removeTag(index)" class="hover:text-white transition-colors">
                    <X class="h-3 w-3" />
                </button>
            </span>
            
            <input
                v-model="inputValue"
                type="text"
                class="flex-1 bg-transparent border-none outline-none text-sm text-white placeholder-gray-600 min-w-[120px]"
                placeholder="Type and press Enter..."
                @keydown.enter.prevent="addTag"
                @keydown="handleKeydown"
                @blur="addTag"
            />
        </div>
        <p class="text-xs text-gray-500">Press Enter/Return to add a technology.</p>
    </div>
</template>
