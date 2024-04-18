<script setup>
import { useForm } from '@inertiajs/vue3';
import SkhcButtonMuted from '@/Components/SkhcButtonMuted.vue';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcInputText from '@/Components/SkhcInputText.vue';
import SkhcInputNumber from '@/Components/SkhcInputNumber.vue';
import SkhcInputDateTime from '@/Components/SkhcInputDateTime.vue';
import SkhcInputSelectGroup from '@/Components/SkhcInputSelectGroup.vue';
import { computed } from 'vue';

const props = defineProps({
    events: { type: Array },
    shiftTime: { type: Object },
});

const emits = defineEmits(['close', 'updated']);

const groups = computed(() => {
    return props.events.map((event) => {
        return {
            id: event.id,
            name: event.name,
            options: event.shifts.map((shift) => ({
                id: shift.id,
                name: shift.name,
            })),
        };
    });
});

const form = useForm({
    label: props.shiftTime.label,
    volunteers_needed: props.shiftTime.volunteers_needed,
    start: props.shiftTime.start,
    end: props.shiftTime.end,
    shift_id: props.shiftTime.shift_id,
});

const submitForm = () =>
    form.put(route('shift-times.update', props.shiftTime), {
        onSuccess: () => emits('updated'),
    });
</script>

<template>
    <form
        @submit.prevent="submitForm"
        class="p-4 flex flex-col space-y-4"
    >
        <SkhcInputSelectGroup
            :error="form.errors.shift_id"
            :groups="groups"
            label="Schicht"
            required
            v-model="form.shift_id"
        />

        <SkhcInputText
            :error="form.errors.label"
            label="Label"
            required
            v-model="form.label"
        />

        <SkhcInputDateTime
            :error="form.errors.start"
            label="Start"
            required
            v-model="form.start"
        />

        <SkhcInputDateTime
            :error="form.errors.end"
            label="End"
            v-model="form.end"
        />

        <SkhcInputNumber
            :error="form.errors.volunteers_needed"
            label="Helfer"
            required
            v-model="form.volunteers_needed"
        />

        <div class="flex justify-end space-x-4">
            <SkhcButtonMuted @click="emits('close')">Schließen</SkhcButtonMuted>
            <SkhcButtonPrimary
                :disabled="form.processing"
                class="disabled:cursor-not-allowed disabled:opacity-50"
                >Speichern</SkhcButtonPrimary
            >
        </div>
    </form>
</template>
