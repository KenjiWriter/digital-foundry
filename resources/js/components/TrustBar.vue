<script setup lang="ts">
// Placeholder text-based logos for now
const companies = [
    { name: 'LogisticsPro', class: 'font-serif font-bold tracking-tight' },
    { name: 'TechFlow', class: 'font-sans font-extrabold tracking-tighter' },
    { name: 'RetailOS', class: 'font-mono font-semibold tracking-wide' },
    { name: 'MedCore', class: 'font-sans font-bold italic' },
    { name: 'FinanceGuard', class: 'font-serif font-black' },
];
</script>

<template>
    <section class="border-y border-border bg-muted/30 py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <p class="mb-6 text-center text-xs font-semibold uppercase tracking-widest text-muted-foreground">
                Trusted by forward-thinking companies
            </p>
            
            <div class="relative flex w-full overflow-hidden">
                <!-- Gradients for smooth fade effect -->
                <div class="absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-background/0 to-transparent sm:from-muted/30"></div>
                <div class="absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-background/0 to-transparent sm:from-muted/30"></div>

                <!-- Marquee Container -->
                <div class="flex animate-marquee whitespace-nowrap">
                    <!-- Original Set -->
                    <div class="flex min-w-full items-center justify-around gap-12 px-12 sm:gap-24 sm:px-24">
                        <span 
                            v-for="company in companies" 
                            :key="company.name" 
                            :class="[company.class, 'text-2xl text-muted-foreground/50 transition-colors hover:text-foreground/80']"
                        >
                            {{ company.name }}
                        </span>
                    </div>
                    
                    <!-- Duplicate Set for Infinity Scroll -->
                    <div class="flex min-w-full items-center justify-around gap-12 px-12 sm:gap-24 sm:px-24">
                         <span 
                            v-for="(company, index) in companies" 
                            :key="`${company.name}-duplicate-${index}`" 
                            :class="[company.class, 'text-2xl text-muted-foreground/50 transition-colors hover:text-foreground/80']"
                        >
                            {{ company.name }}
                        </span>
                    </div>
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
