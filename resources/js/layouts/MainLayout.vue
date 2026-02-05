<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Menu, X, ArrowRight, Github, Twitter, Linkedin } from 'lucide-vue-next';

// Mobile menu state
const isMobileMenuOpen = ref(false);

const currentYear = new Date().getFullYear();

const navLinks = [
    { name: 'Case Studies', href: '/case-studies' },
    { name: 'Services', href: '/services' },
    { name: 'Process', href: '/process' },
];

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>

<template>
    <div class="flex min-h-screen flex-col bg-background font-sans text-foreground antialiased">
        <!-- Navbar (The "Money" Bar) -->
        <header class="sticky top-0 z-50 w-full border-b border-border bg-background/80 backdrop-blur-md">
            <div class="container mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center gap-2 text-xl font-bold tracking-tight text-primary">
                        <span class="text-2xl">ROI</span>Stack
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

                <!-- CTA Button (Desktop) -->
                <div class="hidden md:flex">
                    <Link 
                        href="/strategy-call" 
                        class="inline-flex h-9 items-center justify-center rounded-md bg-accent px-4 py-2 text-sm font-medium text-accent-foreground shadow transition-colors hover:bg-accent/90 focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                    >
                        Book Strategy Call
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
                    <Link 
                        href="/strategy-call" 
                        class="mt-4 flex w-full items-center justify-center gap-2 rounded-md bg-accent px-3 py-2 text-base font-medium text-accent-foreground shadow hover:bg-accent/90"
                        @click="isMobileMenuOpen = false"
                    >
                        Book Strategy Call
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
        <footer class="border-t border-border bg-muted/30">
            <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    
                    <!-- Column 1: Brand/One-liner -->
                    <div class="space-y-4">
                        <Link href="/" class="text-xl font-bold text-primary">ROI Stack</Link>
                        <p class="text-sm leading-relaxed text-muted-foreground">
                            Helping B2B companies automate processes and increase revenue with high-performance software.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-muted-foreground hover:text-primary">
                                <span class="sr-only">Twitter</span>
                                <Twitter class="h-5 w-5" />
                            </a>
                            <a href="#" class="text-muted-foreground hover:text-primary">
                                <span class="sr-only">GitHub</span>
                                <Github class="h-5 w-5" />
                            </a>
                            <a href="#" class="text-muted-foreground hover:text-primary">
                                <span class="sr-only">LinkedIn</span>
                                <Linkedin class="h-5 w-5" />
                            </a>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-foreground">Quick Links</h3>
                        <ul class="mt-4 space-y-2">
                            <li v-for="link in navLinks" :key="link.name">
                                <Link :href="link.href" class="text-sm text-muted-foreground hover:text-primary">
                                    {{ link.name }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/privacy" class="text-sm text-muted-foreground hover:text-primary">Privacy Policy</Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Column 3: Contact Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-foreground">Contact</h3>
                        <ul class="mt-4 space-y-2">
                            <li>
                                <a href="mailto:hello@roistack.com" class="text-sm text-muted-foreground hover:text-primary">
                                    hello@roistack.com
                                </a>
                            </li>
                            <li class="text-sm text-muted-foreground">
                                123 Business Avenue<br>
                                Tech City, TC 90210
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 border-t border-border pt-8">
                    <p class="text-center text-xs text-muted-foreground">
                        &copy; {{ currentYear }} ROI Stack. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

