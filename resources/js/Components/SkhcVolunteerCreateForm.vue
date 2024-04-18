<script setup>
import { useForm } from '@inertiajs/vue3';
import SkhcButtonMuted from '@/Components/SkhcButtonMuted.vue';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcInputText from '@/Components/SkhcInputText.vue';
import SkhcInputNumber from '@/Components/SkhcInputNumber.vue';
import SkhcInputDateTime from '@/Components/SkhcInputDateTime.vue';
import SkhcInputSelectGroup from '@/Components/SkhcInputSelectGroup.vue';
import { computed } from 'vue';
import SkhcInputSelect from '@/Components/SkhcInputSelect.vue';
import DataTable from '@/Skhc/DataTable.vue';
import Column from '@/Skhc/Column.vue';
import VueFeather from 'vue-feather';
import SkhcShiftTimeSelection from '@/Components/SkhcShiftTimeSelection.vue';

const props = defineProps({
    shirt_sizes: Array,
    shift_times: Array,
});

const emits = defineEmits(['close', 'submitted']);

const shiftTimesFormatted = computed(() => {
    return props.shift_times.map((shift_time) => ({
        id: shift_time.id,
        event: shift_time.shift.event.name,
        shift: shift_time.shift.name,
        start: shift_time.start,
        end: shift_time.end,
        comment: shift_time.label,
    }));
});

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    mobile: '',
    shirt_size_id: props.shirt_sizes[0].id,
    shift_time_ids: [],
});

const submitForm = () =>
    form.post(route('volunteers.store'), {
        onSuccess: () => emits('submitted'),
    });
</script>

<template>
    <form
        @submit.prevent="submitForm"
        class="p-4 flex flex-col space-y-4"
    >
        <SkhcInputText
            :error="form.errors.first_name"
            label="Vorname"
            required
            v-model="form.first_name"
        />

        <SkhcInputText
            :error="form.errors.last_name"
            label="Nachname"
            required
            v-model="form.last_name"
        />

        <SkhcInputText
            :error="form.errors.email"
            label="Email"
            required
            v-model="form.email"
        />

        <SkhcInputText
            :error="form.errors.mobile"
            label="Mobile"
            required
            v-model="form.mobile"
        />

        <SkhcInputSelect
            :error="form.errors.shirt_size_id"
            :options="shirt_sizes"
            label="T-Shirt Größe"
            required
            v-model="form.shirt_size_id"
        />

        <div class="bg-gray-50 border-y border-gray-200 -mx-4 p-4">
            <span class="text-lg">Für Schichten anmelden</span>
            <SkhcShiftTimeSelection
                :error="form.errors.shift_time_ids"
                :shift-times="shiftTimesFormatted"
                v-model="form.shift_time_ids"
            />
        </div>

        <div class="flex justify-end space-x-4">
            <SkhcButtonMuted @click="emits('close')">Schließen</SkhcButtonMuted>
            <SkhcButtonPrimary
                :disabled="form.processing"
                class="disabled:cursor-not-allowed disabled:opacity-50"
                >Hinzufügen</SkhcButtonPrimary
            >
        </div>
    </form>
</template>
