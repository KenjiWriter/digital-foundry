<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/Components/AppLogoIcon.vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div
        class="flex min-h-svh flex-col items-center justify-center gap-6 bg-[#0a0f1c] p-6 md:p-10 dark text-white"
    >
        <div class="w-full max-w-sm">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link
                        :href="home()"
                        class="flex flex-col items-center gap-2 font-medium"
                    >
                        <div
                            class="mb-1 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-900/50 border border-blue-800"
                        >
                            <AppLogoIcon
                                class="size-8 fill-current text-blue-200"
                            />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-2xl font-bold tracking-tight text-white">{{ title }}</h1>
                        <p class="text-center text-sm text-gray-400">
                            {{ description }}
                        </p>
                    </div>
                </div>
                <!-- Auth Card -->
                <div class="bg-[#111827] border border-gray-800 rounded-xl p-6 shadow-2xl">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
