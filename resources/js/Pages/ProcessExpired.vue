<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const headline = 'Dieser Vorgang ist bereits abgeschlossen.';
</script>

<template>
    <Head :title="headline" />

    <GuestLayout>
        <h1 class="text-xl text-center">{{ headline }}</h1>
    </GuestLayout>
</template>
