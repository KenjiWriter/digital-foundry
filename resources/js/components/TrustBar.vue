<script setup lang="ts">
import { useTrans } from '@/composables/useTrans';
const { trans } = useTrans();

const integrations = [
    { name: 'InPost', class: 'font-sans font-extrabold tracking-tight' },
    { name: 'Przelewy24', class: 'font-sans font-bold' },
    { name: 'Allegro', class: 'font-sans font-bold tracking-tight' },
    { name: 'Stripe', class: 'font-sans font-bold tracking-tighter' },
    { name: 'DHL', class: 'font-serif font-black italic tracking-wide' },
    { name: 'HubSpot', class: 'font-sans font-semibold' },
    { name: 'wfirma', class: 'font-mono font-medium' },
    { name: 'inFakt', class: 'font-sans font-bold' },
];
</script>

<template>
    <section class="border-y border-border/10 bg-[#020617] py-12 sm:py-16 relative z-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center mb-10">
            <h2 class="text-lg font-semibold uppercase tracking-widest text-accent mb-3">
                Integracje z kluczowymi usługami
            </h2>
            <p class="text-muted-foreground text-sm sm:text-base max-w-2xl mx-auto">
                Tworzymy ekosystemy. Łączymy Twój customowy software z liderami rynku.
            </p>
        </div>
        
        <div class="relative flex w-full overflow-hidden">
            <!-- Gradients for smooth fade effect -->
            <div class="absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-[#020617] to-transparent"></div>
            <div class="absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-[#020617] to-transparent"></div>

            <!-- Marquee Container -->
            <div class="flex animate-marquee whitespace-nowrap">
                <!-- Original Set -->
                <div class="flex min-w-full items-center justify-around gap-12 px-12 sm:gap-24 sm:px-24">
                    <span 
                        v-for="item in integrations" 
                        :key="item.name" 
                        :class="[item.class, 'text-2xl sm:text-3xl text-muted-foreground/50 transition-all duration-300 hover:text-white hover:scale-110 cursor-default']"
                    >
                        {{ item.name }}
                    </span>
                </div>
                
                <!-- Duplicate Set for Infinity Scroll -->
                <div class="flex min-w-full items-center justify-around gap-12 px-12 sm:gap-24 sm:px-24">
                     <span 
                        v-for="(item, index) in integrations" 
                        :key="`${item.name}-duplicate-${index}`" 
                        :class="[item.class, 'text-2xl sm:text-3xl text-muted-foreground/50 transition-all duration-300 hover:text-white hover:scale-110 cursor-default']"
                    >
                        {{ item.name }}
                    </span>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.animate-marquee {
    animation: marquee 30s linear infinite;
}

@keyframes marquee {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

/* Pause on hover for better UX */
.animate-marquee:hover {
    animation-play-state: paused;
}
</style>
