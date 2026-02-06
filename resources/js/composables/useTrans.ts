import { usePage } from '@inertiajs/vue3';

export function useTrans() {
    return <T = string>(key: string): T => {
        const translations = usePage().props.translations as Record<string, any>;
        return translations[key] || key;
    };
}
