<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const headline = 'SpaceKidHeadCup';

function handleRequestLogin() {
    router.post(route('admin-auth.store'));
}
</script>

<template>
    <Head :title="headline" />

    <GuestLayout>
        <h1 class="text-xl text-center mb-6">{{ headline }}</h1>
        <p>
            Werde Teil der legendären SKHC Familie. Wir vernstalten ehrenamtlich
            jedes Jahr am 1. Mai das Weimarer Seifenkistenrennen.
        </p>
        <p>Organisiert von Studierenden, für alle!</p>
        <p>
            Nur, ohne Dich klappt es nicht. Um das Rennen für Klein & Groß
            austragen zu können, benötigen wir deine Hilfe.
        </p>
        <span>Registriere dich jetzt für eine Schicht!</span>
        <Link
            :href="route('volunteer.create')"
            class="bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center"
            data-cta
        >
            Jetzt mitmachen!
        </Link>
        <span>Oder bearbeite oder lösche deine Daten.</span>
        <Link
            :href="route('edit-token.create')"
            class="bg-gray-300 h-16 text-gray-700 font-bold rounded-lg flex justify-center items-center"
            data-cta
        >
            Registrierung bearbeiten
        </Link>
        <p class="italic">
            Deine Daten werden vertraulich verarbeitet und liegen auf einem
            Server in Weimar.
        </p>
        <p class="italic">
            Du kannst deine persönlichen Daten jeder Zeit bearbeiten oder
            löschen.
        </p>
        <p class="italic">
            Deine Daten Name, Email und Telefonnummer verwenden wir zur
            Kommunikation. Kurz vor dem Rennen und der Jubelfeier schicken wir
            dir Informationen zum Treffpunkt für deine Schicht oder Fragen, ob
            noch wer wen kennt, weil noch ein Schichtplatz frei ist.
        </p>
        <p class="italic">
            Deine Daten werden ausschließlich für das Seifenkistenrennen SKHC
            verwendet und nicht an Dritte weitergegeben.
        </p>
        <div class="mt-12 text-right">
            <form @submit.prevent="handleRequestLogin">
                <button type="submit" class="text-gray-300 underline">Admin Stuff</button>
            </form>
        </div>
    </GuestLayout>
</template>

<style>
p {
    @apply mb-6;
}

a[data-cta] {
    @apply mb-4;
}
</style>
