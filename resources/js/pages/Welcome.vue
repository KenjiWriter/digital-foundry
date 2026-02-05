<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
</script>

<template>
    <Head title="Welcome" />

    <MainLayout>
        <HeroSection />
    </MainLayout>
</template>

