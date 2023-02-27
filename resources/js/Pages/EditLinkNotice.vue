<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});
</script>

<template>
    <Head title="Schau in dein Postfach" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">
            Wir haben dir eine Email geschickt
        </h1>
        <p>
            Bitte klicke den Link in der Email, die wir dir an dein Postfach "{{
                email
            }}" geschickt haben, um deine Daten zu ändern.
        </p>
    </GuestLayout>
</template>
