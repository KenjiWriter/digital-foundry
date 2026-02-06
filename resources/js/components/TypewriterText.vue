<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps<{
    text: string | string[];
    speed?: number;
    deleteSpeed?: number;
    delay?: number;
    loop?: boolean;
}>();

const currentText = ref('');
const isTyping = ref(true);

const typeText = async () => {
    isTyping.value = true;
    const texts = Array.isArray(props.text) ? props.text : [props.text];
    
    // Initial delay
    await new Promise(r => setTimeout(r, props.delay || 0));

    let textIndex = 0;
    while (true) {
        const fullText = texts[textIndex];
        
        // Type out
        for (let i = 0; i <= fullText.length; i++) {
            currentText.value = fullText.slice(0, i);
            await new Promise(r => setTimeout(r, props.speed || 100));
        }

        if (!props.loop && textIndex === texts.length - 1) {
            isTyping.value = false;
            break; 
        }

        // Wait before deleting
        await new Promise(r => setTimeout(r, 2000));

        // Delete (if looping or moving to next string)
        for (let i = fullText.length; i >= 0; i--) {
            currentText.value = fullText.slice(0, i);
            await new Promise(r => setTimeout(r, props.deleteSpeed || 50));
        }

        textIndex = (textIndex + 1) % texts.length;
    }
};

onMounted(() => {
    typeText();
});

// Simple implementation without complex cancellation for now
</script>

<template>
    <span>
        {{ currentText }}<span class="animate-pulse ml-0.5 inline-block bg-accent w-1 h-[1em] align-middle" :class="{ 'opacity-0': !isTyping && !loop }"></span>
    </span>
</template>
