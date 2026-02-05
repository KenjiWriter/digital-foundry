<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Mail, CheckCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    website: '',
    pain_point: '',
});

const showSuccess = ref(false);

const submit = () => {
    // Frontend-only simulation for now
    console.log('Form Submitted:', form.data());
    
    // Simulate API delay
    form.processing = true;
    setTimeout(() => {
        form.processing = false;
        showSuccess.value = true;
        form.reset();
        
        // Hide success message after 5 seconds
        setTimeout(() => {
            showSuccess.value = false;
        }, 5000);
    }, 1000);
};
</script>

<template>
    <section id="contact" class="py-16 sm:py-24 bg-card border-t border-border">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-start">
                
                <!-- Left Column: Copy -->
                <div class="space-y-8">
                    <h2 class="text-3xl font-bold tracking-tight text-foreground sm:text-4xl">
                        Let's fix this.
                    </h2>
                    <p class="text-lg text-muted-foreground leading-relaxed">
                        Custom software isn't just about code—it's about reclaiming lost time and revenue. 
                        We build stable, high-performance systems that solve your specific operational headaches.
                    </p>
                    
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-3 text-foreground">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <Mail class="h-5 w-5" />
                            </div>
                            <a href="mailto:hello@roistack.com" class="text-lg font-medium hover:text-primary transition-colors">
                                hello@roistack.com
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form -->
                <div class="bg-muted/10 p-8 rounded-2xl border border-border/50">
                    <div v-if="showSuccess" class="rounded-lg bg-green-500/10 p-4 text-green-500 flex items-center gap-3 border border-green-500/20 mb-6">
                        <CheckCircle class="h-5 w-5" />
                        <span class="font-medium">Request received! We'll be in touch shortly.</span>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                         <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Name
                            </label>
                            <input 
                                id="name" 
                                v-model="form.name"
                                type="text" 
                                required
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="John Doe"
                            />
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Work Email
                            </label>
                            <input 
                                id="email" 
                                v-model="form.email"
                                type="email" 
                                required
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="john@company.com"
                            />
                        </div>

                        <!-- Website -->
                        <div class="space-y-2">
                            <label for="website" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Company Website <span class="text-muted-foreground font-normal ml-1">(Optional)</span>
                            </label>
                            <input 
                                id="website" 
                                v-model="form.website"
                                type="url" 
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="https://company.com"
                            />
                        </div>

                        <!-- Pain Point -->
                        <div class="space-y-2">
                            <label for="pain_point" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                What's your biggest operational pain point?
                            </label>
                            <textarea 
                                id="pain_point" 
                                v-model="form.pain_point"
                                rows="4"
                                required
                                class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="e.g. We spend 10 hours a week merging Excel sheets..."
                            ></textarea>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-primary px-8 py-3 text-base font-semibold text-primary-foreground shadow-sm hover:bg-primary/90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring transition-opacity disabled:opacity-70"
                        >
                            {{ form.processing ? 'Sending...' : 'Request Free Audit' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
