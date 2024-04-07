<script setup>
import SkhcTableBase from '@/Components/SkhcTableBase.vue';
import SkhcSearchInput from '@/Components/SkhcSearchInput.vue';
import { computed, ref } from 'vue';
import _ from 'lodash';
import SkhcInputRadios from '@/Components/SkhcInputRadios.vue';

const props = defineProps({
    hideColumns: Array,
    records: Array,
});

const emits = defineEmits(['record-selected']);

const headers = computed(() => Object.keys(props.records[0]));
const searchTerm = ref('');
const selectedSortBy = ref(headers.value[0]);
const selectedOrder = ref('Aufsteigend');
const orderMap = computed(() => {
    return {
        Aufsteigend: 'asc',
        Absteigend: 'desc',
    }[selectedOrder.value];
});
const filteredRecords = computed(() => {
    return _(props.records)
        .filter((record) => {
            return Object.values(record).join().includes(searchTerm.value);
        })
        .orderBy(selectedSortBy.value, orderMap.value)
        .value();
});
</script>

<template>
    <div>
        <div class="flex items-start space-x-8 mb-4">
            <SkhcSearchInput
                class="w-96"
                v-model="searchTerm"
            />
            <SkhcInputRadios
                :options="headers"
                name="sort"
                title="Sortiere nach"
                v-model="selectedSortBy"
            />
            <SkhcInputRadios
                :options="['Aufsteigend', 'Absteigend']"
                name="order"
                title="Sortierung"
                v-model="selectedOrder"
            />
        </div>

        <SkhcTableBase
            :records="filteredRecords"
            @record-selected="(id) => emits('record-selected', id)"
        />
    </div>
</template>
