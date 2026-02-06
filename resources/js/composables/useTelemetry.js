import { onMounted, onBeforeUnmount, ref } from 'vue';
import { v4 as uuidv4 } from 'uuid';

export function useTelemetry() {
    const sessionId = ref(localStorage.getItem('telemetry_session_id'));
    const events = ref([]);
    const sectionTimers = ref({});
    const currentSection = ref(null);
    const lastSectionEnterTime = ref(Date.now());
    const hasStartedForm = ref(false);
    const isSubmitted = ref(false);

    if (!sessionId.value) {
        sessionId.value = uuidv4();
        localStorage.setItem('telemetry_session_id', sessionId.value);
    }

    const addEvent = (type, payload = {}) => {
        events.value.push({
            type,
            payload: {
                ...payload,
                timestamp: Date.now()
            }
        });
    };

    const sendData = () => {
        if (events.value.length === 0) return;

        const data = {
            session_id: sessionId.value,
            events: events.value
        };

        // Use sendBeacon if available for better reliability on unload
        if (navigator.sendBeacon) {
            const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });
            navigator.sendBeacon('/analytics/track', blob);
            events.value = []; // Clear events after scheduling beacon
        } else {
            // Fallback to fetch
            fetch('/analytics/track', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(data),
                keepalive: true, // Attempt to keep request alive on unload
            }).then(() => {
                events.value = [];
            }).catch(err => console.error('Telemetry error:', err));
        }
    };

    const trackSectionChange = (entry) => {
        const now = Date.now();

        // If we were in a section, record the duration
        if (currentSection.value) {
            const duration = (now - lastSectionEnterTime.value) / 1000; // seconds
            if (duration > 1) { // Ignore flickers
                addEvent('section_view', {
                    section: currentSection.value,
                    duration: duration
                });
            }
        }

        if (entry.isIntersecting) {
            currentSection.value = entry.target.id;
            lastSectionEnterTime.value = now;
        }
    };

    onMounted(() => {
        // Section Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.5) {
                    trackSectionChange(entry);
                }
            });
        }, { threshold: 0.5 });

        ['hero', 'trust-bar', 'roi', 'contact'].forEach(id => {
            const el = document.getElementById(id);
            if (el) observer.observe(el);
        });

        // Form Observer
        const contactForm = document.getElementById('contact-form');
        if (contactForm) {
            const handleInput = () => {
                if (!hasStartedForm.value) {
                    hasStartedForm.value = true;
                    addEvent('form_start');

                    // Remove listener after first input
                    contactForm.removeEventListener('input', handleInput);
                }
            };

            const handleSubmit = () => {
                isSubmitted.value = true;
                addEvent('form_submit');
            };

            contactForm.addEventListener('input', handleInput);
            contactForm.addEventListener('submit', handleSubmit);
        }

        // Periodic sync (every 30s)
        const interval = setInterval(sendData, 30000);

        const handlePageHide = () => {
            // Capture final section time
            if (currentSection.value) {
                const now = Date.now();
                const duration = (now - lastSectionEnterTime.value) / 1000;
                addEvent('section_view', {
                    section: currentSection.value,
                    duration: duration
                });
            }

            // Check for abandoned form
            if (hasStartedForm.value && !isSubmitted.value) {
                addEvent('abandoned_form');
            }

            sendData();
        };

        window.addEventListener('pagehide', handlePageHide);

        onBeforeUnmount(() => {
            clearInterval(interval);
            window.removeEventListener('pagehide', handlePageHide);
            handlePageHide();
        });
    });

    return {
        sessionId
    };
}
