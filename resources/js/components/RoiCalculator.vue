<script setup lang="ts">
import { ref, computed } from 'vue';
import { DollarSign, Clock, Users } from 'lucide-vue-next';

// Inputs
const teamSize = ref(5);
const hoursWastedPerWeek = ref(5);
const hourlyRate = ref(40);

// Calculations
const weeklyLoss = computed(() => {
    return teamSize.value * hoursWastedPerWeek.value * hourlyRate.value;
});

const yearlyLoss = computed(() => {
    return weeklyLoss.value * 52;
});

// Formatting
const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        maximumFractionDigits: 0,
    }).format(value);
};
</script>

<template>
    <section class="py-16 sm:py-24 bg-background">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">
                <div class="text-center mb-12">
                     <h2 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                        Calculate Your Potential Savings
                    </h2>
                    <p class="mt-4 text-lg text-muted-foreground">
                        See how much manual processes are costing your business.
                    </p>
                </div>

                <div class="bg-card border border-border rounded-2xl shadow-2xl overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        
                        <!-- Left Column: Inputs -->
                        <div class="p-8 space-y-8 bg-muted/10">
                            <!-- Team Size Input -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <label for="team-size" class="text-sm font-medium text-foreground flex items-center gap-2">
                                        <Users class="h-4 w-4 text-primary" />
                                        Team Size
                                    </label>
                                    <span class="text-sm font-bold text-primary">{{ teamSize }} people</span>
                                </div>
                                <input 
                                    id="team-size" 
                                    type="range" 
                                    min="1" 
                                    max="50" 
                                    v-model.number="teamSize"
                                    class="w-full h-2 bg-muted rounded-lg appearance-none cursor-pointer accent-accent"
                                />
                            </div>

                            <!-- Hours Wasted Input -->
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                     <label for="hours-wasted" class="text-sm font-medium text-foreground flex items-center gap-2">
                                        <Clock class="h-4 w-4 text-primary" />
                                        Hours Wasted / Person / Week
                                    </label>
                                    <span class="text-sm font-bold text-primary">{{ hoursWastedPerWeek }} hours</span>
                                </div>
                                <input 
                                    id="hours-wasted" 
                                    type="range" 
                                    min="1" 
                                    max="40" 
                                    v-model.number="hoursWastedPerWeek"
                                    class="w-full h-2 bg-muted rounded-lg appearance-none cursor-pointer accent-accent"
                                />
                            </div>

                            <!-- Hourly Rate Input -->
                             <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                     <label for="hourly-rate" class="text-sm font-medium text-foreground flex items-center gap-2">
                                        <DollarSign class="h-4 w-4 text-primary" />
                                        Avg. Hourly Rate
                                    </label>
                                    <span class="text-sm font-bold text-primary">${{ hourlyRate }}/hr</span>
                                </div>
                                <input 
                                    id="hourly-rate" 
                                    type="range" 
                                    min="15" 
                                    max="150" 
                                    step="5" 
                                    v-model.number="hourlyRate"
                                    class="w-full h-2 bg-muted rounded-lg appearance-none cursor-pointer accent-accent"
                                />
                            </div>
                        </div>

                        <!-- Right Column: Results -->
                        <div class="p-8 bg-card flex flex-col justify-center items-center text-center relative overflow-hidden">
                            <!-- Background Glow -->
                             <div class="absolute inset-0 bg-gradient-to-br from-destructive/5 to-transparent pointer-events-none"></div>

                            <p class="text-lg font-medium text-muted-foreground mb-2 relative z-10">
                                You are losing approximately:
                            </p>
                            
                            <div class="text-5xl sm:text-6xl font-black text-destructive mb-4 tracking-tighter relative z-10">
                                {{ formatCurrency(yearlyLoss) }}
                                <span class="text-lg font-medium text-muted-foreground block mt-1">per year</span>
                            </div>

                            <p class="text-sm font-medium text-accent mb-8 relative z-10">
                                We can automate this away.
                            </p>

                            <button class="items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-primary-foreground shadow-sm hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring relative z-10 transition-transform active:scale-95">
                                Stop the Bleeding
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
