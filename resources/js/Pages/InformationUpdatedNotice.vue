<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    volunteer: Object,
});

const editDataRoute = route('edit-token.create');
</script>

<template>
    <Head title="Du hast deine Daten erfolgreich geändert" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">
            Du hast deine Daten erfolgreich geändert.
        </h1>
    </GuestLayout>
</template>
