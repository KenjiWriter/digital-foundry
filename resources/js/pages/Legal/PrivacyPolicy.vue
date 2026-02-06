<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/layouts/MainLayout.vue';
import { useTrans } from '@/composables/useTrans';

const trans = useTrans();

defineProps<{
    content: string;
}>();
</script>

<template>
    <Head :title="trans('legal.privacy')" />

    <MainLayout>
        <div class="container mx-auto px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl">
                <h1 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">{{ trans('legal.privacy') }}</h1>
                <p class="mt-4 text-muted-foreground">{{ trans('legal.last_updated') }} {{ new Date().toLocaleDateString() }}</p>

                <div class="mt-8 prose prose-slate dark:prose-invert max-w-none" v-html="content"></div>
            </div>
        </div>
    </MainLayout>
</template>

