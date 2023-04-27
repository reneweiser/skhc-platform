<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const props = defineProps({
    shifts: Object,
});

const showDeleteModal = ref(false);

function handleVisit(shiftId) {
    router.visit(route('shifts.edit', shiftId));
}

function handleDelete() {
    router.delete(route('shifts.destroy.all'));
    showDeleteModal.value = false;
}
</script>

<template>
    <Head title="Schichten" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alle Schichten
            </h2>
        </template>

        <div class="py-12">
            <div
                id="sections"
                class="mx-auto sm:px-6 lg:px-8"
            >
                <div class="flex justify-end space-x-2">
                    <Link
                        :href="route('shifts.create')"
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                        >Schicht hinzufügen
                    </Link>
                    <button
                        type="button"
                        @click="showDeleteModal = true"
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                    >
                        alle löschen
                    </button>
                </div>

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
                                    Helfer benötigt
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Event
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    zuletzt geändert
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="shiftTime in shifts"
                                :key="shiftTime.email"
                                @click="handleVisit(shiftTime.shift_id)"
                                class="bg-white cursor-pointer border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <th
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row"
                                >
                                    {{ shiftTime.label }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ shiftTime.shift.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ shiftTime.volunteers_needed }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ shiftTime.shift.event.name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ shiftTime.updated_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal
        :show="showDeleteModal"
        @close="showDeleteModal = false"
    >
        <div class="p-6">
            <p class="mb-6 text-xl text-center">
                Bist du sicher, dass du
                <span class="font-bold">alle Schichten</span>
                unwiderruflich löschen willst?
            </p>
            <div class="flex justify-end space-x-4">
                <button
                    type="button"
                    @click="showDeleteModal = false"
                    class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                >
                    Nein
                </button>
                <button
                    type="submit"
                    @click="handleDelete"
                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                >
                    Ja, jetzt löschen
                </button>
            </div>
        </div>
    </Modal>
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
    @apply whitespace-nowrap;
}

p:not(:last-child) {
    @apply mb-4;
}
</style>
