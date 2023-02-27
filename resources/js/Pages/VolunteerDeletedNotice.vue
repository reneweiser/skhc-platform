<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});
</script>

<template>
    <Head title="Du hast deine Daten erfolgreich gelöscht" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">
            Du hast Daten für "{{ email }}" erfolgreich gelöscht.
        </h1>
    </GuestLayout>
</template>
