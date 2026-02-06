<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

// State
const teamSize = ref(5);
const hoursWasted = ref(5);
const hourlyRate = ref(40);

// Translation Helper
const page = usePage();
const t = (key) => {
    return page.props.translations?.[key] || key;
};

// Calculations
const yearlyLoss = computed(() => {
    return teamSize.value * hoursWasted.value * hourlyRate.value * 52;
});

// Formatting
const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0,
    }).format(value);
};

const scrollToContact = () => {
    const el = document.getElementById('contact');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
};
</script>

<template>
    <section class="py-24 bg-slate-900 text-white border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    {{ t('roi.title') }}
                </h2>
                <p class="text-slate-400 text-lg">
                    {{ t('roi.subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-slate-800/50 p-8 rounded-2xl border border-slate-700">
                
                <!-- Left Column: Inputs -->
                <div class="space-y-8">
                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="font-medium text-slate-300">{{ t('roi.team_size') }}</label>
                            <span class="font-bold text-blue-400">{{ teamSize }} people</span>
                        </div>
                        <input 
                            type="range" min="1" max="50" v-model="teamSize"
                            class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-500"
                        />
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="font-medium text-slate-300">{{ t('roi.hours_wasted') }}</label>
                            <span class="font-bold text-blue-400">{{ hoursWasted }} hours</span>
                        </div>
                        <input 
                            type="range" min="1" max="40" v-model="hoursWasted"
                            class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-500" 
                        />
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="font-medium text-slate-300">{{ t('roi.hourly_rate') }}</label>
                            <span class="font-bold text-blue-400">${{ hourlyRate }}/hr</span>
                        </div>
                        <input 
                            type="range" min="15" max="150" step="5" v-model="hourlyRate"
                            class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-blue-500"
                        />
                    </div>
                </div>

                <!-- Right Column: Results -->
                <div class="flex flex-col justify-center items-center text-center p-8 bg-slate-800 rounded-xl border border-slate-600">
                    <p class="text-lg font-medium text-slate-400 mb-2">
                        {{ t('roi.loss_label') }}
                    </p>
                    
                    <div class="text-5xl sm:text-6xl font-black text-red-500 mb-4 tracking-tighter">
                        {{ formatCurrency(yearlyLoss) }}
                        <span class="text-lg font-medium text-slate-400 block mt-1">{{ t('roi.loss_per_year') }}</span>
                    </div>

                    <p class="text-sm font-medium text-blue-400 mb-8">
                        {{ t('roi.automate_msg') }}
                    </p>

                    <button 
                        @click="scrollToContact"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-8 py-3 text-base font-bold text-white shadow-lg hover:bg-blue-500 transition-all active:scale-95"
                    >
                        {{ t('roi.cta') }}
                    </button>
                </div>

            </div>
        </div>
    </section>
</template>
