<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Menu, X, ArrowRight, Github, Twitter, Linkedin } from 'lucide-vue-next';
import { useTrans } from '@/composables/useTrans';
import Footer from '@/Components/Footer.vue';
import CookieBanner from '@/Components/CookieBanner.vue';

// Mobile menu state
const isMobileMenuOpen = ref(false);
const { trans } = useTrans();

const currentYear = new Date().getFullYear();

import { computed } from 'vue';

const navLinks = computed(() => [
    { name: trans('nav.case_studies'), href: '/case-studies' },
    { name: trans('nav.services'), href: '/services' },
    { name: trans('nav.process'), href: '/process' },
]);

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

import { Globe } from 'lucide-vue-next';
import { onClickOutside } from '@vueuse/core';

const languages = [
    { code: 'en', label: 'EN' },
    { code: 'pl', label: 'PL' },
    { code: 'es', label: 'ES' },
    { code: 'ru', label: 'RU' },
];

const isLangOpen = ref(false);
const langMenuRef = ref(null);

onClickOutside(langMenuRef, () => {
    isLangOpen.value = false;
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-background font-sans text-foreground antialiased">
        <!-- Navbar (The "Money" Bar) -->
        <header class="sticky top-0 z-50 w-full border-b border-border bg-background/80 backdrop-blur-md">
            <div class="container mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center gap-2 text-xl font-bold tracking-tight text-primary">
                        {{ $page.props.appName }}
                    </Link>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex md:items-center md:gap-8">
                    <Link 
                        v-for="link in navLinks" 
                        :key="link.name" 
                        :href="link.href" 
                        class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary"
                    >
                        {{ link.name }}
                    </Link>
                </nav>

                <!-- Language Switcher -->
                <div class="hidden md:flex items-center space-x-1 mr-4">
                    <div class="relative" ref="langMenuRef">
                        <button 
                            @click="isLangOpen = !isLangOpen"
                            class="flex items-center space-x-1 text-sm font-medium text-muted-foreground hover:text-primary transition-colors focus:outline-none"
                        >
                            <Globe class="h-4 w-4" />
                            <span class="uppercase">{{ $page.props.locale }}</span>
                        </button>
                        <!-- Dropdown -->
                        <div 
                            v-if="isLangOpen"
                            class="absolute right-0 mt-2 w-24 origin-top-right rounded-md bg-background shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none animate-in fade-in zoom-in-95 duration-200"
                        >
                             <div class="py-1">
                                <a 
                                    v-for="lang in languages" 
                                    :key="lang.code"
                                    :href="`/language/${lang.code}`"
                                    class="block px-4 py-2 text-sm text-foreground hover:bg-accent hover:text-accent-foreground"
                                    :class="{ 'font-bold': lang.code === $page.props.locale }"
                                >
                                    {{ lang.label }}
                                </a>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Button (Desktop) -->
                <div class="hidden md:flex">
                    <Link 
                        href="/strategy-call" 
                        class="inline-flex h-9 items-center justify-center rounded-md bg-accent px-4 py-2 text-sm font-medium text-accent-foreground shadow transition-colors hover:bg-accent/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                    >
                        {{ trans('nav.book_call') }}
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden">
                    <button 
                        @click="toggleMobileMenu" 
                        class="inline-flex items-center justify-center rounded-md p-2 text-muted-foreground hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                    >
                        <span class="sr-only">Open main menu</span>
                        <Menu v-if="!isMobileMenuOpen" class="h-6 w-6" aria-hidden="true" />
                        <X v-else class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div v-if="isMobileMenuOpen" class="md:hidden border-t border-border bg-background">
                <div class="space-y-1 px-4 pb-3 pt-2">
                    <Link 
                        v-for="link in navLinks" 
                        :key="link.name" 
                        :href="link.href" 
                        class="block rounded-md px-3 py-2 text-base font-medium text-muted-foreground hover:bg-accent hover:text-accent-foreground"
                        @click="isMobileMenuOpen = false"
                    >
                        {{ link.name }}
                    </Link>
                    
                    <!-- Mobile Languages -->
                    <div class="flex flex-wrap gap-2 px-3 py-2">
                         <a 
                            v-for="lang in languages" 
                            :key="lang.code"
                            :href="`/language/${lang.code}`"
                            class="px-2 py-1 text-sm border rounded-md"
                            :class="lang.code === $page.props.locale ? 'bg-primary text-primary-foreground border-primary' : 'border-border text-muted-foreground'"
                        >
                            {{ lang.label }}
                        </a>
                    </div>
                    
                    <Link 
                        href="/strategy-call" 
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-md bg-accent px-3 py-2 text-base font-medium text-accent-foreground shadow hover:bg-accent/90"
                        @click="isMobileMenuOpen = false"
                    >
                        {{ trans('nav.book_call') }}
                        <ArrowRight class="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </header>

        <!-- Main Content (Slot) -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <Footer />
        
        <!-- Cookie Banner -->
        <CookieBanner />
    </div>
</template>

