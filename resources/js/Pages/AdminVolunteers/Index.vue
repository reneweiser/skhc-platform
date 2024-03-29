<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const props = defineProps({
    volunteers: Object,
});

const showDeleteModal = ref(false);
const count = props.volunteers.data.length;

function handleVisit(volunteerId) {
    router.visit(route('admin.volunteer.edit', volunteerId));
}

function handleDelete() {
    router.delete(route('admin.volunteer.destroy.all'));
    showDeleteModal.value = false;
}

function shiftsToString(shifts) {
    const shiftNames = shifts.map((item) => item.name);
    const count = shiftNames.length > 3 ? ` (+${shiftNames.length - 3})` : '';

    return shiftNames.slice(0, 3).join(', ') + count;
}
</script>

<template>
    <Head title="Helfer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alle Helfer
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
                <div class="flex justify-end space-x-2">
                    <Link
                        :href="route('admin.volunteer.create')"
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                        >Helfer hinzufügen
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
                                    Vorname
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Nachname
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Schichten
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3"
                                    scope="col"
                                >
                                    Mobile
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
                                v-for="volunteer in volunteers.data"
                                :key="volunteer.email"
                                @click="handleVisit(volunteer.id)"
                                class="bg-white cursor-pointer border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <th
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    scope="row"
                                >
                                    {{ volunteer.first_name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ volunteer.last_name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{
                                        shiftsToString(
                                            volunteer.selected_shifts
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ volunteer.email }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ volunteer.mobile }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ volunteer.updated_at }}
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
                Bist du sicher, dass du die Daten
                <span class="font-bold">aller Helfer</span>
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
