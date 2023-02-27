<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    volunteer: Object,
});

const editDataRoute = route('edit-token.create');
</script>

<template>
    <Head title="Deine Registrierung ist jetzt abgeschlossen" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">
            Deine Registrierung ist jetzt abgeschlossen
        </h1>
        <p>
            Wenn du deine Daten ändern willst, kannst du einen
            <a
                :href="editDataRoute"
                class="font-bold text-sky-800"
                >temporären Zugang</a
            >
            anfordern. Gib dort deine hinterlegte Email Adresse "{{
                volunteer.email
            }}" an.
        </p>
    </GuestLayout>
</template>
