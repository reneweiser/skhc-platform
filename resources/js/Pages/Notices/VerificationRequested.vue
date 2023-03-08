<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    email: String,
});

const headline = 'Anmeldung abschließen';
</script>

<template>
    <Head :title="headline" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">{{ headline }}</h1>
        <p class="text-xl font-bold text-center">
            Danke!<br />Um deine Registrierung abzuschließen, bestätige bitte
            den Bestätigungslink in deiner Mail.
        </p>
        <p>
            Wir haben an {{ email }} eine Email mit dem Bestätigungslink
            versendet. Keine erhalten?<br />
            <Link
                :href="route('volunteer.create')"
                class="bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center"
                data-cta
            >
                Erneut versenden!
            </Link>
        </p>
        <h2 class="font-bold">Falsche Email?</h2>
        <p>
            <Link
                :href="route('edit-token.create')"
                class="bg-gray-300 h-16 text-gray-700 font-bold rounded-lg flex justify-center items-center"
                data-cta
            >
                Bitte registriere dich noch einmal.
            </Link>
        </p>
        <p>
            PS: Deine Registrierung kann mit dem Bestätigungslink in den
            nächsten 6h abgeschlossen werden. Wenn die Bestätigung nicht
            erfolgt, werden deine Daten gelöscht.
        </p>
    </GuestLayout>
</template>

<style>
p {
    @apply mb-12;
}
</style>
