<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import TrustBar from '@/Components/TrustBar.vue';
import RoiCalculator from '@/Components/RoiCalculator.vue';
import ContactSection from '@/Components/ContactSection.vue';
import { useTelemetry } from '@/Composables/useTelemetry';

useTelemetry();
</script>

<template>
    <Head title="Welcome" />

    <MainLayout>
        <div id="hero">
            <HeroSection />
        </div>
        <div id="trust-bar">
            <TrustBar />
        </div>
        <div id="roi">
            <RoiCalculator />
        </div>
        <div id="contact">
            <ContactSection />
        </div>
    </MainLayout>
</template>

