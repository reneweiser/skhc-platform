<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});

const headline = 'Du hast deinen persönlichen Zugang erneut angefordert';
</script>

<template>
    <Head :title="headline" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">{{ headline }}</h1>
        <p>
            Bitte klicke den Link in der Email, die wir dir an dein Postfach "{{
                email
            }}" geschickt haben, um deine Daten zu ändern.
        </p>
    </GuestLayout>
</template>
