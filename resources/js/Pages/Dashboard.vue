<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    count: Number,
    shoppingList: Array,
    spotsFilled: Array
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div id="sections" class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden max-w-lg mx-auto shadow-sm sm:rounded-lg p-4">
                    <p>Es haben sich bisher <span class="font-bold">{{count}}</span> Helfer angemeldet.</p>
                    <p>
                        Du kannst hier die Daten aller Helfer herunterladen.
                    </p>
                    <a :href="route('volunteers.download')" class="bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center">Download</a>
                </div>

                <div class="bg-white overflow-hidden max-w-lg mx-auto shadow-sm sm:rounded-lg p-4">
                    <h2>Shopping List</h2>
                    <p>Helfer haben sich diese Größen gewünscht.</p>
                    <table class="w-full">
                        <tr>
                            <th>Größe</th>
                            <th>Anzahl</th>
                        </tr>
                        <tr v-for="size in shoppingList" :key="size.name">
                            <td>{{size.name.toUpperCase()}}</td>
                            <td>{{size.total}}</td>
                        </tr>
                    </table>
                </div>

                <div class="bg-white overflow-scroll shadow-sm sm:rounded-lg p-4">
                    <h2>Unbeliebte Schichten</h2>
                    <p>Diese Schichten brauchen noch die meisten Helfer.</p>
                    <table>
                        <tr>
                            <th>braucht insgesamt</th>
                            <th>braucht noch</th>
                            <th>Besetzung in %</th>
                            <th>Zeit</th>
                            <th>Schicht</th>
                            <th>Event</th>
                        </tr>
                        <tr v-for="spot in spotsFilled" :key="spot.shift_time_id">
                            <td>{{spot.volunteers_needed}}</td>
                            <td>{{spot.remaining}}</td>
                            <td>{{spot.filledPercent}}</td>
                            <td>{{spot.shift_time}}</td>
                            <td>{{spot.shift_name}}</td>
                            <td>{{spot.event_name}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
h2{
    @apply text-xl font-bold mb-4;
}
#sections>div:not(:last-child) {
    @apply mb-4;
}

th, td {
    @apply border whitespace-nowrap;
}

p:not(:last-child) {
    @apply mb-4;
}
</style>
