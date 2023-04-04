<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});

const headline = 'Du hast Admin Stuff angefordert, schau im Orga Postfach nach.';
</script>

<template>
    <Head :title="headline" />
    <GuestLayout>
        <h1 class="text-xl text-center">{{ headline }}</h1>
    </GuestLayout>
</template>
