<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    count: Number,
    shoppingList: Array,
    spotsFilled: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div
                id="sections"
                class="mx-auto sm:px-6 lg:px-8"
            >
                <div
                    class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
                >
                    <p>
                        Es haben sich bisher
                        <span class="font-bold">{{ count }}</span> Helfer
                        angemeldet.
                    </p>
                    <p>Du kannst hier die Daten aller Helfer herunterladen.</p>
                    <a
                        :href="route('volunteers.download')"
                        class="bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center"
                        >Download</a
                    >
                </div>

                <h2>Shopping List</h2>
                <p>Helfer haben sich diese Größen gewünscht.</p>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Größe
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Anzahl
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="size in shoppingList"
                                :key="size.name"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <th
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row"
                                >
                                    {{ size.name.toUpperCase() }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ size.total }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>Unbeliebte Schichten</h2>
                <p>Diese Schichten brauchen noch die meisten Helfer.</p>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Zeit
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Schicht
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Helfer benötigt (gesamt)
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Helfer benötigt (verbleibend)
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Besetzung (in %)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="spot in spotsFilled"
                                :key="spot.shift_time_id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <th
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row"
                                >
                                    {{ spot.shift_time }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ spot.shift_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ spot.volunteers_needed }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ spot.remaining }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ spot.filledPercent }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
h2 {
    @apply text-xl font-bold mb-4;
}
#sections > div:not(:last-child) {
    @apply mb-4;
}

th,
td {
    @apply border whitespace-nowrap;
}

p:not(:last-child) {
    @apply mb-4;
}
</style>
