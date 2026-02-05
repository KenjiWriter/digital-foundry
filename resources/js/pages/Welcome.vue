<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import TrustBar from '@/Components/TrustBar.vue';
import RoiCalculator from '@/Components/RoiCalculator.vue';
import ContactSection from '@/Components/ContactSection.vue';
</script>

<template>
    <Head title="Welcome" />

    <MainLayout>
        <HeroSection />
        <TrustBar />
        <RoiCalculator />
        <ContactSection />
    </MainLayout>
</template>

