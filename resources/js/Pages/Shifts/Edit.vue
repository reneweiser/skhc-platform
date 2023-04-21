<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Card from '@/Components/Card.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
import TextArea from '@/Components/TextArea.vue';
import { marked } from 'marked';
import SelectInput from '@/Components/SelectInput.vue';
import NumberInput from '@/Components/NumberInput.vue';
import { onMounted } from 'vue';
import {
    createForm,
    handleAddShiftTime,
    handleRemoveShiftTime,
    moveDown,
    moveUp,
} from '@/Pages/Shifts/Helpers';

const props = defineProps({
    events: Array,
    shift: Object,
});

onMounted(() => {
    if (form.shift_times.length === 0) handleAddShiftTime();
});

const headline = 'Schicht erstellen';

const form = createForm({
    event: props.shift.event_id,
    name: props.shift.name,
    meeting_place: props.shift.meeting_place,
    description: props.shift.description,
    shift_times: props.shift.shift_times,
});

function handleSubmit() {
    form.put(route('shifts.update', props.shift.id));
}
</script>

<template>
    <Head :title="headline" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ headline }}
            </h2>
        </template>

        <div
            id="content"
            class="py-12"
        >
            <div
                id="sections"
                class="mx-auto sm:px-6 lg:px-8"
            >
                <Card class="max-w-screen-md mx-auto">
                    <form
                        class="flex flex-col space-y-4"
                        @submit.prevent="handleSubmit"
                    >
                        <SelectInput
                            v-model.number="form.event"
                            :options="events"
                            label="Wähle ein Event für die Schicht"
                            name="event"
                        />
                        <TextInput
                            v-model="form.name"
                            label="Name"
                            name="name"
                            required
                        />
                        <TextInput
                            v-model="form.meeting_place"
                            label="Treffpunkt"
                            name="meeting_place"
                            required
                        />
                        <div class="flex space-x-4">
                            <div class="w-1/2">
                                <TextArea
                                    v-model="form.description"
                                    class="font-mono"
                                    label="Beschreibung"
                                    name="description"
                                ></TextArea>
                            </div>
                            <div class="h-full w-1/2">
                                <div
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >
                                    Preview
                                </div>
                                <div
                                    id="preview"
                                    v-html="marked(form.description)"
                                ></div>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <div class="shift-times-grid">
                                <span>Zeit</span>
                                <span>Helfer</span>
                                <span></span>
                            </div>
                            <div
                                v-for="(
                                    shiftTime, shiftTimeIndex
                                ) in form.shift_times"
                                :key="shiftTimeIndex"
                                class="shift-times-grid"
                            >
                                <TextInput
                                    v-model="shiftTime.label"
                                    :name="`shiftTime.${shiftTimeIndex}.label`"
                                    required
                                />
                                <NumberInput
                                    v-model.number="shiftTime.volunteers_needed"
                                    :name="`shiftTime.${shiftTimeIndex}.volunteers_needed`"
                                    required
                                />
                                <div
                                    class="inline-flex rounded-md shadow-sm"
                                    role="group"
                                >
                                    <button
                                        class="w-1/3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                                        type="button"
                                        @click="
                                            handleRemoveShiftTime(
                                                form,
                                                shiftTimeIndex
                                            )
                                        "
                                    >
                                        &minus;
                                    </button>
                                    <button
                                        class="w-1/3 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                                        type="button"
                                        @click="
                                            handleAddShiftTime(
                                                form,
                                                shiftTimeIndex
                                            )
                                        "
                                    >
                                        &plus;
                                    </button>
                                    <button
                                        class="w-1/3 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                                        type="button"
                                        @click="moveUp(form, shiftTimeIndex)"
                                    >
                                        &uarr;
                                    </button>
                                    <button
                                        class="w-1/3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                                        type="button"
                                        @click="moveDown(form, shiftTimeIndex)"
                                    >
                                        &darr;
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button
                                :disabled="form.processing"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                type="submit"
                            >
                                Speichern
                            </button>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
#content > h2 {
    @apply text-xl font-bold mb-4;
}

#sections > div:not(:last-child) {
    @apply mb-4;
}

#preview h3 {
    @apply font-bold text-xl;
}

#preview ul {
    @apply list-inside list-disc;
}

#preview a {
    @apply text-sky-600 underline;
}

th,
td {
    @apply whitespace-nowrap;
}

p:not(:last-child) {
    @apply mb-4;
}

.shift-times-grid {
    display: grid;
    gap: 0.5rem;
    grid-template-columns: 1fr 4rem 1fr;
}
</style>
