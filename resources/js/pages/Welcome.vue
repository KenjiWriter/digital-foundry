<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import TrustBar from '@/Components/TrustBar.vue';
import BusinessAudit from '@/Components/Landing/BusinessAudit.vue';
import ContactSection from '@/Components/ContactSection.vue';
import { useTelemetry } from '@/composables/useTelemetry';
import { useCookieConsent } from '@/composables/useCookieConsent';

const props = defineProps<{
    auditSectors?: any[];
    canRegister?: boolean;
}>();

const { consentStatus } = useCookieConsent();

if (consentStatus.value === 'granted') {
    useTelemetry();
}
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
        <div id="audit">
            <BusinessAudit :sectors="props.auditSectors" />
        </div>
        <div id="contact">
            <ContactSection />
        </div>
    </MainLayout>
</template>

