<script setup lang="ts">
import { useCookieConsent } from '@/composables/useCookieConsent';
import { useTrans } from '@/composables/useTrans';
import { Link } from '@inertiajs/vue3';

const { consentStatus, setConsent } = useCookieConsent();
const { trans } = useTrans();
</script>

<template>
    <div 
        v-if="!consentStatus"
        class="fixed bottom-0 right-0 left-0 z-50 p-4 md:p-6 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 border-t border-border shadow-2xl"
    >
        <div class="container mx-auto max-w-7xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-muted-foreground text-center sm:text-left">
                <p>
                    {{ trans('cookie.text') }}
                    <Link href="/privacy-policy" class="underline hover:text-primary">{{ trans('cookie.policy') }}</Link>.
                </p>
            </div>
            <div class="flex gap-3">
                <button 
                    @click="setConsent('denied')"
                    class="px-4 py-2 text-sm font-medium text-foreground bg-secondary hover:bg-secondary/80 rounded-md transition-colors"
                >
                    {{ trans('cookie.reject') }}
                </button>
                <button 
                    @click="setConsent('granted')"
                    class="px-4 py-2 text-sm font-medium text-primary-foreground bg-primary hover:bg-primary/90 rounded-md shadow transition-colors"
                >
                    {{ trans('cookie.accept') }}
                </button>
            </div>
        </div>
    </div>
</template>
