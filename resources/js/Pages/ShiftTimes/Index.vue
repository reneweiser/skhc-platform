<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SkhcShiftTimesTable from '@/Components/SkhcShiftTimesTable.vue';
import Modal from '@/Components/Modal.vue';
import { computed, ref } from 'vue';
import SkhcShiftTimeUpdateForm from '@/Components/SkhcShiftTimeUpdateForm.vue';
import VueFeather from 'vue-feather';

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
        item.shift.name,
        item.start,
        item.end,
        item.shift.meeting_place,
        item.volunteers_needed,
    ])
);

const showRowModal = ref(false);
let selectedShiftTime = null;

function selectRow(index) {
    selectedShiftTime = props.shiftTimes[index];
    showRowModal.value = true;
}

function shortenText(text, limit) {
    if (text.length < limit) return text;
    return text.substring(0, limit) + '(...)';
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
