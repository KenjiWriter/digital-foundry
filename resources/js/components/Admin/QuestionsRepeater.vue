<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import { Card, CardContent } from '@/Components/ui/card';
import { Badge } from '@/Components/ui/badge';
import { Plus, Trash, GripVertical, AlertCircle } from 'lucide-vue-next';

const props = defineProps<{
    modelValue: any[];
}>();

const emit = defineEmits(['update:modelValue']);

const addQuestion = () => {
    const newQuestion = {
        question_text: { en: '', pl: '' },
        variable_name: '',
        cost_per_unit: 0,
        suggestion_text: { en: '', pl: '' }
    };
    emit('update:modelValue', [...props.modelValue, newQuestion]);
};

const removeQuestion = (index: number) => {
    const updated = [...props.modelValue];
    updated.splice(index, 1);
    emit('update:modelValue', updated);
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <Label class="text-base font-semibold text-white">Audit Questions</Label>
            <Button type="button" variant="outline" size="sm" @click="addQuestion" class="border-dashed border-gray-600 text-gray-400 hover:text-white hover:bg-gray-800">
                <Plus class="w-4 h-4 mr-2" />
                Add Question
            </Button>
        </div>

        <div v-if="props.modelValue.length === 0" class="text-center py-8 bg-gray-900/40 border border-dashed border-gray-800 rounded-xl">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-800 mb-4">
                <AlertCircle class="w-6 h-6 text-gray-500" />
            </div>
            <p class="text-gray-400 text-sm">No questions added yet.</p>
            <p class="text-gray-500 text-xs mt-1">Add questions to calculate ROI for this sector.</p>
        </div>

        <div class="space-y-4">
            <Card v-for="(question, index) in props.modelValue" :key="index" class="bg-gray-900/60 border border-gray-800 relative group">
                <CardContent class="p-6">
                    <div class="absolute right-4 top-4 opacity-0 group-hover:opacity-100 transition-opacity">
                         <Button type="button" variant="ghost" size="icon" @click="removeQuestion(index)" class="text-red-400 hover:text-red-300 hover:bg-red-900/20">
                            <Trash class="w-4 h-4" />
                        </Button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left: Core Logic -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-2">
                                <Badge variant="outline" class="bg-blue-900/20 text-blue-400 border-blue-900/50">Question {{ index + 1 }}</Badge>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <Label class="text-xs text-gray-500">Variable Name</Label>
                                    <Input v-model="question.variable_name" class="bg-black/50 border-gray-800 text-white h-8" placeholder="e.g. manual_returns" />
                                </div>
                                <div class="space-y-2">
                                    <Label class="text-xs text-gray-500">Cost per Unit ($)</Label>
                                    <Input v-model="question.cost_per_unit" type="number" step="0.01" class="bg-black/50 border-gray-800 text-white h-8" />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <Label class="text-xs text-gray-400">Question Text (EN)</Label>
                                <Input v-model="question.question_text.en" class="bg-black/50 border-gray-800 text-white" placeholder="Question in English" />
                            </div>
                            <div class="space-y-2">
                                <Label class="text-xs text-gray-400">Question Text (PL)</Label>
                                <Input v-model="question.question_text.pl" class="bg-black/50 border-gray-800 text-white" placeholder="Pytanie po polsku" />
                            </div>
                        </div>

                        <!-- Right: Suggestions -->
                        <div class="space-y-4 border-l border-gray-800 pl-6">
                             <div class="space-y-2">
                                <Label class="text-xs text-gray-400">Suggestion / Promise (EN)</Label>
                                <Textarea v-model="question.suggestion_text.en" rows="3" class="bg-black/50 border-gray-800 text-white resize-none" placeholder="Value proposition..." />
                            </div>
                            <div class="space-y-2">
                                <Label class="text-xs text-gray-400">Suggestion / Promise (PL)</Label>
                                <Textarea v-model="question.suggestion_text.pl" rows="3" class="bg-black/50 border-gray-800 text-white resize-none" placeholder="Propozycja wartości..." />
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
