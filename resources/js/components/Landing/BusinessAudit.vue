<script setup lang="ts">
import { ref, computed } from 'vue';
import { useTrans } from '@/composables/useTrans';
import { Button } from '@/Components/ui/button';
import { Card, CardContent } from '@/Components/ui/card';
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Truck, ShoppingBag, Briefcase, Activity, ArrowRight, RotateCcw } from 'lucide-vue-next';

// --- Props ---
const props = defineProps<{
    sectors?: any[];
}>();

const { trans, locale } = useTrans();
const getIcon = (name: string) => {
    switch (name) {
        case 'Truck': return Truck;
        case 'ShoppingBag': return ShoppingBag;
        case 'Briefcase': return Briefcase;
        default: return Activity;
    }
};

// --- State ---
const step = ref(1);
const selectedSector = ref<any>(null);
const answers = ref<Record<string, number>>({});

// --- Computed ---
const totalLoss = computed(() => {
    if (!selectedSector.value) return 0;
    
    let sum = 0;
    selectedSector.value.questions.forEach((q: any) => {
        const val = answers.value[q.id] || 0;
        sum += val * q.cost_per_unit;
    });
    return sum;
});

const topSuggestion = computed(() => {
    if (!selectedSector.value) return null;

    let maxLoss = -1;
    let topQ: any = null;

    selectedSector.value.questions.forEach((q: any) => {
        const val = answers.value[q.id] || 0;
        const loss = val * q.cost_per_unit;
        if (loss > maxLoss) {
            maxLoss = loss;
            topQ = q;
        }
    });

    return topQ;
});

// --- Actions ---
const selectSector = (sector: any) => {
    selectedSector.value = sector;
    // Initialize answers
    sector.questions.forEach((q: any) => {
        answers.value[q.id] = 0;
    });
    step.value = 2;
};

const calculate = () => {
    step.value = 3;
};

const reset = () => {
    step.value = 1;
    selectedSector.value = null;
    answers.value = {};
};

const scrollToContact = () => {
    document.getElementById('contact')?.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <section class="py-24 bg-black relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-blue-900/20 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                 <h2 class="text-3xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-500 mb-6">
                    {{ trans('roi.title', 'Business Audit Engine') }}
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    {{ trans('roi.subtitle', 'Diagnose hidden costs in your operations.') }}
                </p>
            </div>

            <!-- Transition Wrapper -->
            <transition name="fade" mode="out-in">
                
                <!-- STEP 1: Select Industry -->
                <div v-if="step === 1" key="step1" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div 
                        v-for="sector in props.sectors" 
                        :key="sector.id"
                        @click="selectSector(sector)"
                        class="group cursor-pointer p-8 rounded-2xl bg-gray-900/40 border border-white/5 hover:border-blue-500/50 hover:bg-gray-800/60 transition-all duration-300 transform hover:-translate-y-1"
                    >
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-800 to-black flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl shadow-black/50">
                            <component :is="getIcon(sector.icon)" class="w-8 h-8 text-blue-400 group-hover:text-blue-300" />
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">{{ sector.name[locale] || sector.name.en }}</h3>
                        <div class="h-1 w-12 bg-blue-900/50 rounded-full group-hover:w-full group-hover:bg-blue-500 transition-all duration-500"></div>
                    </div>
                </div>

                <!-- STEP 2: The Audit -->
                <div v-else-if="step === 2" key="step2" class="max-w-2xl mx-auto">
                    <Card class="bg-gray-900/60 border-gray-800 backdrop-blur-sm">
                        <CardContent class="p-8 space-y-8">
                            <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-800">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 rounded-lg bg-blue-900/20 text-blue-400">
                                        <component :is="getIcon(selectedSector.icon)" class="w-6 h-6" />
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">{{ selectedSector.name[locale] || selectedSector.name.en }}</h3>
                                </div>
                                <Button variant="ghost" size="sm" @click="reset" class="text-gray-500 hover:text-white">
                                    <RotateCcw class="w-4 h-4 mr-2" />
                                    Change
                                </Button>
                            </div>

                            <div v-for="question in selectedSector.questions" :key="question.id" class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <Label class="text-base text-gray-300">
                                        {{ question.question_text[locale] || question.question_text.en }}
                                    </Label>
                                    <span class="text-blue-400 font-mono font-bold">{{ answers[question.id] }}</span>
                                </div>
                                <Input 
                                    type="number" 
                                    v-model="answers[question.id]" 
                                    class="bg-black/50 border-gray-700 text-white"
                                    min="0"
                                />
                                <!-- Optional: Add Slider if needed, but Input is safer for various ranges -->
                            </div>

                            <Button @click="calculate" class="w-full h-12 text-lg bg-blue-600 hover:bg-blue-500 text-white font-bold shadow-lg shadow-blue-900/20">
                                Calculate Potential Savings
                                <ArrowRight class="ml-2 w-5 h-5" />
                            </Button>
                        </CardContent>
                    </Card>
                </div>

                <!-- STEP 3: Results -->
                <div v-else key="step3" class="max-w-2xl mx-auto text-center">
                    <div class="p-8 rounded-3xl bg-gradient-to-b from-gray-900 to-black border border-white/10 shadow-2xl relative overflow-hidden">
                        
                        <!-- Glow effect -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-1/2 bg-blue-500/10 blur-3xl pointer-events-none"></div>

                        <p class="text-gray-400 mb-2 uppercase tracking-widest text-sm font-bold">Estimated Annual Loss</p>
                        <div class="text-6xl md:text-7xl font-black text-white mb-8 tracking-tighter">
                            ${{ totalLoss.toLocaleString() }}
                        </div>

                        <div v-if="topSuggestion" class="bg-blue-900/20 border border-blue-500/30 p-6 rounded-xl mb-8 text-left">
                            <div class="flex items-start gap-4">
                                <Activity class="w-6 h-6 text-blue-400 mt-1 shrink-0" />
                                <div>
                                    <h4 class="text-lg font-bold text-white mb-2">Recommendation</h4>
                                    <p class="text-gray-300 leading-relaxed">
                                        {{ topSuggestion.suggestion_text[locale] || topSuggestion.suggestion_text.en }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Button @click="scrollToContact" class="h-12 px-8 bg-white text-black hover:bg-gray-200 font-bold text-base">
                                Book a Fix Strategy
                            </Button>
                             <Button variant="outline" @click="reset" class="h-12 px-8 border-gray-700 text-gray-400 hover:text-white hover:bg-white/5">
                                Start Over
                            </Button>
                        </div>
                    </div>
                </div>

            </transition>
        </div>
    </section>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
