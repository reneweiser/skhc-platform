<script setup>
import SkhcTableBase from '@/Components/SkhcTableBase.vue';
import SkhcSearchInput from '@/Components/SkhcSearchInput.vue';
import { computed, ref } from 'vue';
import _ from 'lodash';
import SkhcInputRadios from '@/Components/SkhcInputRadios.vue';

const props = defineProps({
    headers: Array,
    rows: Array,
});

const emits = defineEmits(['row-selected']);

const searchTerm = ref('');
const selectedSortBy = ref(props.headers[0]);
const selectedOrder = ref('asc');

const filteredRows = computed(() =>
    _(props.rows)
        .filter((row) => row.join().includes(searchTerm.value))
        .orderBy(
            props.headers.findIndex((item) => item === selectedSortBy.value),
            selectedOrder.value
        )
        .value()
);
</script>

<template>
    <div>
        <div>
            <SkhcSearchInput
                class="w-96"
                v-model="searchTerm"
            />
        </div>
        <div class="flex space-x-8">
            <SkhcInputRadios
                :options="headers"
                name="sort"
                title="Sortiere nach"
                v-model="selectedSortBy"
            />
            <SkhcInputRadios
                :options="['asc', 'desc']"
                name="order"
                title="Sortierung"
                v-model="selectedOrder"
            />
        </div>

        <SkhcTableBase
            :headers="headers"
            :rows="filteredRows"
            @row-selected="(index) => emits('row-selected', index)"
        />
    </div>
</template>
