<script setup>
import { ref, computed } from 'vue';
import { useTrans } from '@/composables/useTrans';
import { auditScenarios } from '@/Configs/audit-scenarios';
import { 
    ShoppingBag, 
    Truck, 
    Briefcase, 
    ArrowRight, 
    Check,
    RotateCcw,
    DollarSign
} from 'lucide-vue-next';

const t = useTrans();

// Icons map - Mapping from config strings (HeroIcon style) to Lucide components
const iconMap = {
    ShoppingBagIcon: ShoppingBag,
    TruckIcon: Truck,
    BriefcaseIcon: Briefcase
};

// State
const step = ref(1);
const selectedIndustryId = ref(null);
const selectedPainPointIds = ref([]);
const metrics = ref({});
const hourlyRate = ref(40); // Default, could be configurable

// Computed
const selectedIndustry = computed(() => 
    auditScenarios.find(s => s.id === selectedIndustryId.value)
);

const selectedPainPoints = computed(() => 
    selectedIndustry.value?.painPoints.filter(p => selectedPainPointIds.value.includes(p.id)) || []
);

const totalYearlyLoss = computed(() => {
    if (!selectedIndustry.value) return 0;
    
    let totalMinutesMonthly = 0;
    
    selectedPainPoints.value.forEach(pp => {
        const metricValue = metrics.value[pp.metric.id] || pp.metric.defaultValue;
        // Impact is minutes saved per unit * number of units
        totalMinutesMonthly += metricValue * pp.impact.minutesSavedPerUnit;
    });

    const yearlyMinutes = totalMinutesMonthly * 12;
    const yearlyHours = yearlyMinutes / 60;
    return yearlyHours * hourlyRate.value;
});

// Formatting
const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0,
    }).format(value);
};

// Actions
const selectIndustry = (id) => {
    selectedIndustryId.value = id;
    selectedPainPointIds.value = [];
    metrics.value = {};
    step.value = 2;
};

const togglePainPoint = (id) => {
    if (selectedPainPointIds.value.includes(id)) {
        selectedPainPointIds.value = selectedPainPointIds.value.filter(pId => pId !== id);
    } else {
        selectedPainPointIds.value.push(id);
    }
};

const goToQuantify = () => {
    // Initialize metrics with default values for selected pain points
    selectedPainPoints.value.forEach(pp => {
        if (metrics.value[pp.metric.id] === undefined) {
            metrics.value[pp.metric.id] = pp.metric.defaultValue;
        }
    });
    step.value = 3;
};

const goToResults = () => {
    step.value = 4;
};

const reset = () => {
    step.value = 1;
    selectedIndustryId.value = null;
    selectedPainPointIds.value = [];
    metrics.value = {};
};

const scrollToContact = () => {
    const el = document.getElementById('contact');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <section class="py-24 bg-slate-900 text-white border-t border-slate-800 relative overflow-hidden">
        <!-- Background Gradients -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <span class="text-blue-400 font-semibold tracking-wider text-sm uppercase mb-2 block">{{ t('audit.badge') || 'Discovery Engine' }}</span>
                <h2 class="text-3xl md:text-5xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">
                    {{ t('audit.title') || 'Interactive Business Audit' }}
                </h2>
                <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                    {{ t('audit.subtitle') || 'Diagnose implementation gaps and calculate your potential savings in minutes.' }}
                </p>
            </div>

            <!-- Wizard Container -->
            <div class="bg-slate-800/50 backdrop-blur-lg rounded-2xl border border-slate-700 p-8 shadow-xl transition-all duration-500"
                 :class="{'ring-2 ring-blue-500/20': step > 1}">
                
                <!-- Progress Bar -->
                <div class="flex items-center justify-between mb-8 px-4" v-if="step < 4">
                    <div class="flex gap-2">
                        <div v-for="i in 3" :key="i" 
                             class="h-2 rounded-full transition-all duration-300"
                             :class="i <= step ? 'w-8 bg-blue-500' : 'w-2 bg-slate-700'">
                        </div>
                    </div>
                    <span class="text-xs text-slate-500 font-mono uppercase">Step {{ step }} of 3</span>
                </div>

                <!-- Step 1: Industry Selection -->
                <div v-if="step === 1" class="space-y-6">
                    <h3 class="text-xl font-semibold text-center mb-8">{{ t('audit.step1_title') || 'Select your industry' }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button v-for="industry in auditScenarios" :key="industry.id"
                            @click="selectIndustry(industry.id)"
                            class="group relative flex flex-col items-center p-6 bg-slate-800 rounded-xl border border-slate-700 hover:border-blue-500/50 hover:bg-slate-750 transition-all hover:-translate-y-1">
                            <div class="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center mb-4 group-hover:bg-blue-500/20 group-hover:text-blue-400 transition-colors">
                                <component :is="iconMap[industry.icon]" class="w-6 h-6" />
                            </div>
                            <span class="font-medium text-slate-200">{{ industry.label }}</span>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Pain Points -->
                <div v-if="step === 2" class="space-y-6">
                     <div class="flex items-center gap-4 mb-6">
                        <button @click="step = 1" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 hover:text-white transition-colors">
                            <ArrowRight class="w-5 h-5 rotate-180" />
                        </button>
                        <h3 class="text-xl font-semibold">{{ t('audit.step2_title') || 'What challenges do you face?' }}</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div v-for="point in selectedIndustry.painPoints" :key="point.id"
                             @click="togglePainPoint(point.id)"
                             class="relative p-4 rounded-xl border cursor-pointer transition-all flex items-start gap-4 group"
                             :class="selectedPainPointIds.includes(point.id) 
                                ? 'bg-blue-500/10 border-blue-500/50' 
                                : 'bg-slate-800 border-slate-700 hover:border-slate-600'">
                            
                            <div class="mt-1 w-6 h-6 rounded border flex items-center justify-center transition-colors"
                                 :class="selectedPainPointIds.includes(point.id) ? 'bg-blue-500 border-blue-500' : 'border-slate-500'">
                                <Check v-if="selectedPainPointIds.includes(point.id)" class="w-4 h-4 text-white" />
                            </div>
                            
                            <div>
                                <h4 class="font-medium" :class="selectedPainPointIds.includes(point.id) ? 'text-blue-400' : 'text-slate-200'">{{ point.label }}</h4>
                                <p class="text-sm text-slate-400 mt-1">{{ point.description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button @click="goToQuantify" 
                                :disabled="selectedPainPointIds.length === 0"
                                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-3 rounded-lg font-semibold transition-all">
                            {{ t('audit.next') || 'Analyze Impact' }}
                            <ArrowRight class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <!-- Step 3: Quantify -->
                <div v-if="step === 3" class="space-y-8">
                     <div class="flex items-center gap-4 mb-6">
                        <button @click="step = 2" class="p-2 hover:bg-slate-700 rounded-lg text-slate-400 hover:text-white transition-colors">
                            <ArrowRight class="w-5 h-5 rotate-180" />
                        </button>
                        <h3 class="text-xl font-semibold">{{ t('audit.step3_title') || 'Quantify the volume' }}</h3>
                    </div>

                    <div class="space-y-8">
                        <div v-for="point in selectedPainPoints" :key="point.id" class="bg-slate-800/50 p-6 rounded-xl border border-slate-700/50">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                <label class="font-medium text-slate-200 text-lg">{{ point.question }}</label>
                                <div class="bg-slate-900 px-3 py-1 rounded-lg border border-slate-700 text-blue-400 font-mono font-bold">
                                    {{ metrics[point.metric.id] }} {{ point.metric.unit }}
                                </div>
                            </div>
                            <input 
                                type="range" 
                                :min="point.metric.min" 
                                :max="point.metric.max" 
                                :step="point.metric.step"
                                v-model.number="metrics[point.metric.id]"
                                class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-500"
                            />
                            <div class="flex justify-between text-xs text-slate-500 mt-2 font-mono">
                                <span>{{ point.metric.min }}</span>
                                <span>{{ point.metric.max }}</span>
                            </div>
                        </div>
                        
                        <!-- Hourly Rate Adjustment (Optional) -->
                        <div class="pt-4 border-t border-slate-700">
                             <div class="flex justify-between mb-2">
                                <label class="font-medium text-slate-400 text-sm">Avg. Hourly Cost (Team)</label>
                                <span class="font-bold text-slate-300">${{ hourlyRate }}/hr</span>
                            </div>
                            <input 
                                type="range" min="15" max="150" step="5" v-model="hourlyRate"
                                class="w-full h-1 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-slate-500"
                            />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button @click="goToResults" 
                                class="flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-green-900/20 transition-all hover:scale-105">
                            {{ t('audit.calculate') || 'Generate Diagnosis' }}
                            <DollarSign class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <!-- Step 4: Results -->
                <div v-if="step === 4" class="text-center animate-in fade-in zoom-in duration-500">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500/20 text-green-400 mb-6">
                        <DollarSign class="w-8 h-8" />
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-2 text-white">
                        {{ t('audit.results_title') || 'Potential Annual Savings' }}
                    </h3>
                     <p class="text-slate-400 mb-8 max-w-md mx-auto">
                        By automating these {{ selectedPainPoints.length }} workflows, your business could recover:
                    </p>

                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 p-8 rounded-2xl mb-8 relative group">
                        <div class="absolute inset-0 bg-blue-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="text-5xl sm:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-500 tracking-tighter mb-2">
                            {{ formatCurrency(totalYearlyLoss) }}
                        </div>
                        <p class="text-slate-500 font-medium">per year</p>
                    </div>

                    <button 
                        @click="scrollToContact"
                        class="w-full md:w-auto inline-flex items-center justify-center rounded-lg bg-blue-600 px-8 py-4 text-lg font-bold text-white shadow-xl hover:bg-blue-500 transition-all active:scale-95 mb-6 hover:shadow-blue-500/25 ring-4 ring-transparent hover:ring-blue-500/20">
                        {{ t('audit.cta_proposal') || 'Get a Correction Plan' }}
                        <ArrowRight class="w-5 h-5 ml-2" />
                    </button>

                    <button @click="reset" class="block mx-auto text-slate-500 hover:text-white flex items-center gap-2 text-sm transition-colors">
                        <RotateCcw class="w-4 h-4" />
                        {{ t('audit.restart') || 'Start Over' }}
                    </button>
                </div>

            </div>
        </div>
    </section>
</template>
