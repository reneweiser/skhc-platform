<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});

const headline = 'Du hast deine Daten erfolgreich gelöscht';
</script>

<template>
    <Head :title="headline" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">{{ headline }}</h1>
    </GuestLayout>
</template>
