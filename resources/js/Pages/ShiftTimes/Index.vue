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

const records = computed(() =>
    props.shiftTimes.map((item) => ({
        id: item.id,
        Name: shortenText(item.label, 25),
        Schicht: shortenText(item.shift.name, 25),
        Start: item.start,
        Ende: item.end,
        Treffpunkt: shortenText(item.shift.meeting_place, 25),
        Helfer: item.volunteers_needed,
    }))
);

const showRowModal = ref(false);
let selectedShiftTime = null;

function selectRecord(id) {
    selectedShiftTime = props.shiftTimes.find((item) => item.id === id);
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
            :hide-columns="['id']"
            :records="records"
            @record-selected="selectRecord"
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
