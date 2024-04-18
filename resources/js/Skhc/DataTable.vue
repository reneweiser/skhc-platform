<script setup>
import { computed, ref, useSlots } from 'vue';
import _ from 'lodash';
import SkhcSearchInput from '@/Components/SkhcSearchInput.vue';
import SkhcInputRadios from '@/Components/SkhcInputRadios.vue';
import SkhcInputSelect from '@/Components/SkhcInputSelect.vue';

const props = defineProps({
    rows: Array,
    searchable: Boolean,
    sortable: Boolean,
});

const columns = useSlots()
    .default()
    .map((slot) => slot.props);

const sortables = columns.map((column) => ({
    value: column.field,
    label: column.header,
}));

const directions = [
    { value: 'asc', label: 'aufsteigend' },
    { value: 'desc', label: 'absteigend' },
];

const searchTerm = ref('');
const orderByColumn = ref(columns[0].field);
const direction = ref('asc');

const filteredRows = computed(() => {
    return _(props.rows)
        .filter((row) =>
            Object.values(row)
                .join()
                .toLowerCase()
                .includes(searchTerm.value.toLowerCase())
        )
        .orderBy(orderByColumn.value, direction.value)
        .value();
});
</script>

<template>
    <div class="space-y-4">
        <div class="space-y-4">
            <div v-if="searchable">
                <SkhcSearchInput
                    class="min-w-80"
                    v-model="searchTerm"
                />
                <span class="block text-right font-bold text-xs mt-2"
                    >{{ filteredRows.length }} Zeilen</span
                >
            </div>

            <div
                class="space-y-4"
                v-if="sortable"
            >
                <SkhcInputRadios
                    :options="sortables"
                    name="order-by"
                    title="Sortiere nach"
                    v-model="orderByColumn"
                />
                <SkhcInputRadios
                    :options="directions"
                    name="sort"
                    title="Sortierung"
                    v-model="direction"
                />
            </div>
        </div>
        <div
            class="relative overflow-x-auto rounded-none lg:rounded-xl shadow-lg"
        >
            <table
                class="w-full bg-white text-sm text-left rtl:text-right text-gray-500"
            >
                <thead class="text-xs text-gray-700 uppercase">
                    <tr class="border-b">
                        <th
                            :key="column.field"
                            class="px-6 py-3 whitespace-nowrap"
                            scope="col"
                            v-for="column in columns"
                        >
                            {{ column.header }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        :key="row.id"
                        class="border-b"
                        v-for="row in filteredRows"
                    >
                        <td
                            class="px-6 py-4"
                            v-for="header in columns"
                        >
                            {{ row[header.field] }}
                        </td>
                        <slot
                            :row="row"
                            name="row"
                        />
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
