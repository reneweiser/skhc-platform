<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});
</script>

<template>
    <Head title="Anmeldung abschließen" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">Anmeldung abschließen</h1>
        <p class="mb-4">Danke, dass du dich zum helfen gemeldet hast.</p>
        <p>
            Bitte klicke den Link in der Email, die wir dir an dein Postfach "{{
                email
            }}" geschickt haben, um deine Registrierung abzuschließen.
        </p>
    </GuestLayout>
</template>
