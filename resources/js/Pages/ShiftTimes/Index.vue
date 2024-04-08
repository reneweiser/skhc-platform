<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import SkhcShiftTimeUpdateForm from '@/Components/SkhcShiftTimeUpdateForm.vue';
import VueFeather from 'vue-feather';
import { shortenText } from '@/helpers';
import SkhcTableFiltered from '@/Components/SkhcTableFiltered.vue';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcModalHeader from '@/Components/SkhcModalHeader.vue';
import SkhcShiftTimeCreateForm from '@/Components/SkhcShiftTimeCreateForm.vue';
import SkhcShiftTimeDeleteForm from '@/Components/SkhcShiftTimeDeleteForm.vue';
import Modal from '@/Components/Modal.vue';

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

const showCreateModal = ref(false);
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

        <div class="flex justify-end mt-4">
            <SkhcButtonPrimary @click="showCreateModal = true">
                Timeslot erstellen
            </SkhcButtonPrimary>
        </div>

        <SkhcTableFiltered
            :hide-columns="['id']"
            :records="records"
            @record-selected="selectRecord"
            class="mt-4"
        />
    </AuthenticatedLayout>

    <Modal
        :show="showCreateModal"
        @close="showCreateModal = false"
    >
        <SkhcModalHeader @close="showCreateModal = false" />
        <SkhcShiftTimeCreateForm
            :events="events"
            @submitted="showCreateModal = false"
        />
    </Modal>

    <Modal
        :show="showRowModal"
        @close="showRowModal = false"
    >
        <SkhcModalHeader @close="showRowModal = false" />
        <SkhcShiftTimeUpdateForm
            :events="events"
            :shift-time="selectedShiftTime"
            @close="showRowModal = false"
            @updated="showRowModal = false"
        />
        <SkhcShiftTimeDeleteForm
            :shift-time="selectedShiftTime"
            @deleted="showRowModal = false"
            class="m-4"
        />
    </Modal>
</template>
