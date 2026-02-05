<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
</script>

<template>
    <Head title="Welcome" />

    <MainLayout>
        <div class="flex h-[calc(100vh-16rem)] items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-primary sm:text-6xl">
                    Hero Section Coming Soon
                </h1>
                <p class="mt-6 text-lg leading-8 text-muted-foreground">
                    Layout Integration Successful
                </p>
            </div>
        </div>
    </MainLayout>
</template>
