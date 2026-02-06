import { ref } from 'vue';

const consentStatus = ref(localStorage.getItem('cookie_consent')); // 'granted', 'denied', or null

export function useCookieConsent() {
    const setConsent = (status) => {
        consentStatus.value = status;
        localStorage.setItem('cookie_consent', status);

        if (status === 'granted') {
            window.dispatchEvent(new Event('cookie-consent-granted'));
        }
    };

    return {
        consentStatus,
        setConsent
    };
}
