<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    count: Number,
    shoppingList: Array
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div id="sections" class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p>Es haben sich bisher <span class="font-bold">{{count}}</span> Helfer angemeldet.</p>
                    <p>
                        Du kannst hier die Daten aller Helfer herunterladen.
                    </p>
                    <a :href="route('volunteers.download')" class="bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center">Download</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
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
    @apply border;
}

p:not(:last-child) {
    @apply mb-4;
}
</style>
