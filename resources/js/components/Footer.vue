<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { useTrans } from '@/composables/useTrans';
import AppLogo from '@/Components/AppLogo.vue';
import { Twitter, Github, Linkedin, Mail } from 'lucide-vue-next';
import { computed } from 'vue';

const { trans } = useTrans();
const currentYear = new Date().getFullYear();

const navLinks = computed(() => [
    { name: trans('nav.case_studies'), href: '/case-studies' },
    { name: trans('nav.services'), href: '/services' },
    { name: trans('nav.process'), href: '/process' },
]);
</script>

<template>
    <footer class="border-t border-border bg-muted/30">
        <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                
                <!-- Column 1: Brand/One-liner -->
                <div class="space-y-4">
                    <Link href="/" class="text-xl font-bold text-primary">{{ $page.props.appName }}</Link>
                    <p class="text-sm leading-relaxed text-muted-foreground">
                        {{ trans('footer.brand_desc') }}
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
                    <h3 class="text-sm font-semibold text-foreground">{{ trans('footer.quick_links') }}</h3>
                    <ul class="mt-4 space-y-2">
                        <li v-for="link in navLinks" :key="link.name">
                            <Link :href="link.href" class="text-sm text-muted-foreground hover:text-primary">
                                {{ link.name }}
                            </Link>
                        </li>
                        <li>
                            <Link href="/privacy-policy" class="text-sm text-muted-foreground hover:text-primary">{{ trans('legal.privacy') }}</Link>
                        </li>
                        <li>
                            <Link href="/terms-of-service" class="text-sm text-muted-foreground hover:text-primary">{{ trans('legal.terms') }}</Link>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Contact Info -->
                <div>
                    <h3 class="text-sm font-semibold text-foreground">{{ trans('footer.contact') }}</h3>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="mailto:hello@digitalfoundry.com" class="text-sm text-muted-foreground hover:text-primary">
                                hello@digitalfoundry.com
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
                    &copy; {{ currentYear }} {{ $page.props.appName }}. {{ trans('footer.rights') }}
                </p>
            </div>
        </div>
    </footer>
</template>
