<script setup>
import VueFeather from 'vue-feather';
import { computed } from 'vue';

const props = defineProps({
    hideColumns: Array,
    records: Array,
});

const emits = defineEmits(['record-selected']);

const headers = computed(() => Object.keys(props.records[0]));

function showColumn(column) {
    return props.hideColumns ? !props.hideColumns.includes(column) : true;
}
</script>

<template>
    <div>
        <div class="mt-2 relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500"
            >
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3"
                            scope="col"
                            v-for="header in headers"
                            v-show="showColumn(header)"
                        >
                            {{ header }}
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        :class="{ 'bg-gray-50': row_index % 2 }"
                        :key="row_index"
                        class="border-b"
                        v-for="(row, row_index) in records"
                    >
                        <td
                            :key="column_index"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                            v-for="(value, key, column_index) in row"
                            v-show="showColumn(key)"
                        >
                            {{ value }}
                        </td>
                        <td
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                        >
                            <button @click="emits('record-selected', row.id)">
                                <VueFeather type="more-vertical" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
