<script setup>
import VueFeather from 'vue-feather';

defineProps({
    headers: { type: Array },
    rows: { type: Array },
});

const emits = defineEmits(['row-selected']);
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
                        v-for="(row, row_index) in rows"
                    >
                        <td
                            :key="column_index"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                            v-for="(column, column_index) in row"
                        >
                            {{ column }}
                        </td>
                        <td
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                        >
                            <button @click="emits('row-selected', row_index)">
                                <VueFeather type="more-vertical" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
