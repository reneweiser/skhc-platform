<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { shortenText } from '@/helpers';
import VueFeather from 'vue-feather';
import Modal from '@/Components/Modal.vue';
import SkhcShiftUpdateForm from '@/Components/SkhcShiftUpdateForm.vue';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcTableFiltered from '@/Components/SkhcTableFiltered.vue';
import SkhcModalHeader from '@/Components/SkhcModalHeader.vue';
import SkhcShiftCreateForm from '@/Components/SkhcShiftCreateForm.vue';
import SkhcShiftDeleteForm from '@/Components/SkhcShiftDeleteForm.vue';
import DataTable from '@/Skhc/DataTable.vue';
import Column from '@/Skhc/Column.vue';

const props = defineProps({
    shifts: Array,
    events: Array,
    visibilities: Array,
});

const showCreateModal = ref(false);
const showRowModal = ref(false);
let selectedShift = null;

const records = computed(() =>
    props.shifts.map((item) => ({
        id: item.id,
        name: shortenText(item.name, 25),
        meeting_place: shortenText(item.meeting_place, 25),
        event: shortenText(item.event.name, 25),
        visibility: item.visibility.label,
    }))
);

const visibilitiesFormatted = computed(() =>
    props.visibilities.map((item) => ({
        id: item.id,
        name: item.label,
    }))
);

function selectRecord(id) {
    selectedShift = props.shifts.find((item) => item.id === id);
    showRowModal.value = true;
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

        <div class="flex justify-end mt-4">
            <SkhcButtonPrimary @click="showCreateModal = true">
                Schicht erstellen
            </SkhcButtonPrimary>
        </div>

        <DataTable
            :rows="records"
            class="mt-4 sm:mt-2"
            searchable
            sortable
        >
            <Column
                field="name"
                header="Name"
            />
            <Column
                field="meeting_place"
                header="Treffpunkt"
            />
            <Column
                field="event"
                header="Event"
            />
            <Column
                field="visibility"
                header="Sichtbarkeit"
            />

            <template #row="{ row }">
                <button
                    @click="selectRecord(row.id)"
                    class="px-6 py-4"
                    type="button"
                >
                    <VueFeather type="more-vertical" />
                </button>
            </template>
        </DataTable>
    </AuthenticatedLayout>

    <Modal
        :show="showCreateModal"
        @close="showCreateModal = false"
    >
        <SkhcModalHeader @close="showCreateModal = false" />
        <SkhcShiftCreateForm
            :events="events"
            :visibilities="visibilitiesFormatted"
            @submitted="showCreateModal = false"
        />
    </Modal>

    <Modal
        :show="showRowModal"
        @close="showRowModal = false"
    >
        <SkhcModalHeader @close="showRowModal = false" />
        <SkhcShiftUpdateForm
            :events="events"
            :shift="selectedShift"
            :visibilities="visibilitiesFormatted"
            @updated="showRowModal = false"
            class="m-4"
        />
        <SkhcShiftDeleteForm
            :shift="selectedShift"
            @deleted="showRowModal = false"
            class="m-4"
        />
    </Modal>
</template>
