import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useTrans() {
    const page = usePage();

    const trans = <T = string>(key: string, defaultVal?: string): T => {
        const translations = page.props.translations as Record<string, any>;
        return translations?.[key] || defaultVal || key;
    };

    const locale = computed(() => (page.props.locale as string) || 'en');

    return {
        trans,
        locale
    };
}
