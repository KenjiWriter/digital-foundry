<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import HeroSection from '@/Components/HeroSection.vue';
import TrustBar from '@/Components/TrustBar.vue';
import BusinessAudit from '@/Components/Landing/BusinessAudit.vue';
import ContactSection from '@/Components/ContactSection.vue';
import { useTelemetry } from '@/composables/useTelemetry';
import { useCookieConsent } from '@/composables/useCookieConsent';
import DigitalGlobe from '@/Components/DigitalGlobe.vue';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps<{
    auditSectors?: any[];
    canRegister?: boolean;
}>();

const { consentStatus } = useCookieConsent();

if (consentStatus.value === 'granted') {
    useTelemetry();
}

const isGlobeLoading = ref(true);

onMounted(() => {
    // Lock Scroll
    document.body.style.overflow = 'hidden';

    // Lock for 1.5s then Zoom Out (Matches HeroSection timing + transition)
    setTimeout(() => {
        isGlobeLoading.value = false;
        // Unlock Scroll
        document.body.style.overflow = '';
    }, 1200);
});

onUnmounted(() => {
    // Safety cleanup
    document.body.style.overflow = '';
});
</script>

<template>
    <Head title="Cerasus Digital | Dedykowane Oprogramowanie dla Biznesu">
        <meta name="description" content="Przekształć swój biznes dzięki dedykowanym aplikacjom webowym. Jesteśmy software housem specjalizującym się w skalowalnych rozwiązaniach Laravel i Vue.">
        <link rel="canonical" :href="($page.props.url as string)" />
    </Head>

    <!-- Digital Globe (Page Level Overlay) -->
    <div 
        :class="[
            isGlobeLoading 
                ? 'fixed inset-0 z-[99999] bg-slate-900 w-screen h-screen flex items-center justify-center' 
                : 'fixed top-0 left-0 w-full h-[100vh] z-0 opacity-60 pointer-events-none transition-all duration-[1500ms] ease-in-out transform will-change-transform-opacity'
        ]"
    >
        <DigitalGlobe />
    </div>

    <MainLayout>
        <div id="hero" class="relative z-10">
            <HeroSection />
        </div>
        <div id="trust-bar" class="relative z-20 bg-[#020617]">
            <TrustBar />
        </div>
        <div id="audit" class="relative z-20 bg-[#020617]">
            <BusinessAudit :sectors="props.auditSectors" />
        </div>
        <div id="contact" class="relative z-20 bg-[#020617]">
            <ContactSection />
        </div>
    </MainLayout>
</template>

