<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from '@/Skhc/DataTable.vue';
import Column from '@/Skhc/Column.vue';
import { computed } from 'vue';
import { shortenText } from '@/helpers';

const props = defineProps({
    count: Number,
    shoppingList: Array,
    spotsFilled: Array,
});

const spotsFilledFormatted = computed(() => {
    return props.spotsFilled.map((spot) => ({
        shift: shortenText(spot.shift_name, 25),
        timeslot: shortenText(spot.shift_time, 25),
        remaining: spot.remaining,
        filled_percent: spot.filledPercent,
    }));
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

        <div class="space-y-2 mt-8">
            <h2 class="text-xl">Shopping List</h2>
            <p>Helfer haben sich diese Größen gewünscht.</p>
            <DataTable
                :rows="shoppingList"
                class="mt-4 sm:mt-2"
                sortable
            >
                <Column
                    field="name"
                    header="Größe"
                />
                <Column
                    field="total"
                    header="Anzahl"
                />
            </DataTable>
        </div>

        <div class="space-y-2 mt-8">
            <h2 class="text-xl">Unbeliebte Schichten</h2>
            <p>Diese Schichten brauchen noch die meisten Helfer.</p>
            <DataTable
                :rows="spotsFilledFormatted"
                class="mt-4 sm:mt-2"
                searchable
                sortable
            >
                <Column
                    field="shift"
                    header="Schicht"
                />
                <Column
                    field="timeslot"
                    header="Timeslot"
                />
                <Column
                    field="remaining"
                    header="Fehlen noch"
                />
                <Column
                    field="filled_percent"
                    header="besetzt in Prozent"
                />
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>
