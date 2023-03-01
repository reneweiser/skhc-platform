<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});

const editDataRoute = route('edit-token.create');
const headline = 'Deine Registrierung ist jetzt abgeschlossen';
</script>

<template>
    <Head :title="headline" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">
            {{ headline }}
        </h1>
        <p>
            Wenn du deine Daten ändern willst, kannst du einen
            <a
                :href="editDataRoute"
                class="font-bold text-sky-800"
                >temporären Zugang</a
            >
            anfordern. Gib dort deine hinterlegte Email Adresse "{{ email }}"
            an.
        </p>
    </GuestLayout>
</template>
