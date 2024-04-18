<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import VueFeather from 'vue-feather';
import DataTable from '@/Skhc/DataTable.vue';
import Column from '@/Skhc/Column.vue';
import { computed, ref } from 'vue';
import { shortenText } from '@/helpers';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcVolunteerCreateForm from '@/Components/SkhcVolunteerCreateForm.vue';
import Modal from '@/Components/Modal.vue';
import SkhcModalHeader from '@/Components/SkhcModalHeader.vue';
import SkhcVolunteerUpdateForm from '@/Components/SkhcVolunteerUpdateForm.vue';

const props = defineProps({
    volunteers: Object,
    shift_times: Array,
    shirt_sizes: Array,
});

const showCreateModal = ref(false);
const showRowModal = ref(false);
let selectedVolunteer = null;

function selectRecord(id) {
    selectedVolunteer = props.volunteers.data.find((item) => item.id === id);
    showRowModal.value = true;
}

const records = computed(() => {
    return props.volunteers.data.map((volunteer) => ({
        id: volunteer.id,
        first_name: volunteer.first_name,
        last_name: volunteer.last_name,
        email: volunteer.email,
        mobile: volunteer.mobile,
        shifts: shortenText(
            volunteer.selected_shifts.map((shift) => shift.name).join(', '),
            25
        ),
    }));
});
</script>

<template>
    <Head title="Helfer" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Alle Helfer
            </h2>
        </template>

        <div class="flex items-center justify-end mt-4">
            <SkhcButtonPrimary @click="showCreateModal = true"
                >Helfer hinzufügen</SkhcButtonPrimary
            >
        </div>

        <DataTable
            :rows="records"
            class="mt-4"
            searchable
            sortable
        >
            <Column
                field="first_name"
                header="Vorname"
            />
            <Column
                field="last_name"
                header="Nachname"
            />
            <Column
                field="email"
                header="Email"
            />
            <Column
                field="mobile"
                header="Handynummer"
            />
            <Column
                field="shifts"
                header="Schichten"
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
        <SkhcVolunteerCreateForm
            :shift_times="shift_times"
            :shirt_sizes="shirt_sizes"
            @close="showCreateModal = false"
            @submitted="showCreateModal = false"
        />
    </Modal>

    <Modal
        :show="showRowModal"
        @close="showRowModal = false"
    >
        <SkhcModalHeader @close="showRowModal = false" />
        <SkhcVolunteerUpdateForm
            :shift_times="shift_times"
            :shirt_sizes="shirt_sizes"
            :volunteer="selectedVolunteer"
            @close="showRowModal = false"
            @submitted="showRowModal = false"
        />
    </Modal>
</template>
