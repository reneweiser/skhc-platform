<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SkhcShiftTimesTable from '@/Components/SkhcTableBase.vue';
import Modal from '@/Components/Modal.vue';
import { computed, ref } from 'vue';
import SkhcShiftTimeUpdateForm from '@/Components/SkhcShiftTimeUpdateForm.vue';
import VueFeather from 'vue-feather';
import { shortenText } from '@/helpers';

const props = defineProps({
    events: { type: Array },
    shiftTimes: { type: Array },
});

const tableHeaders = [
    'Bezeichnung',
    'Schicht',
    'Anfang',
    'Ende',
    'Treffpunkt',
    'Helfer',
];

const tableRows = computed(() =>
    props.shiftTimes.map((item) => [
        shortenText(item.label, 25),
        shortenText(item.shift.name, 25),
        item.start,
        item.end,
        shortenText(item.shift.meeting_place, 25),
        item.volunteers_needed,
    ])
);

const showRowModal = ref(false);
let selectedShiftTime = null;

function selectRow(index) {
    selectedShiftTime = props.shiftTimes[index];
    showRowModal.value = true;
}
</script>

<template>
    <Head title="Timeslots" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Timeslots
            </h2>
        </template>

        <SkhcShiftTimesTable
            :headers="tableHeaders"
            :rows="tableRows"
            @row-selected="selectRow"
        />
    </AuthenticatedLayout>

    <Modal
        :show="showRowModal"
        @close="showRowModal = false"
    >
        <div class="flex justify-end px-2 pt-2 bg-gray-100">
            <button @click="showRowModal = false">
                <VueFeather
                    size="20"
                    type="x"
                />
            </button>
        </div>
        <SkhcShiftTimeUpdateForm
            :events="events"
            :shift-time="selectedShiftTime"
            @close="showRowModal = false"
            @updated="showRowModal = false"
        />
    </Modal>
</template>
