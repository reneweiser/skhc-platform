<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PacmanLoader from 'vue-spinner/src/PacmanLoader.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {groupBy} from 'lodash';
import {ref} from "vue";

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    mobile: '',
    shirt_size_id: '',
    selected_shifts: [],
});

const props = defineProps({
    shirtSizes: Array,
    shifts: Object,
    spots: Array,
});

const events = groupBy(props.shifts.data, shift => shift.event_name);

const spotsLookup = props.spots.reduce((acc, cur) => {
    acc[cur['shift_time_id']] = cur['signed_up'];
    return acc;
}, {})

const panelStates = ref([]);

function handleSubmit() {
    form.post(route('volunteer.store'));
}

function canSelectShiftTime(shiftTime) {
    if (shiftTime.needs_more_volunteers)
        return true;

    return form.selected_shifts.includes(shiftTime.id)
}

function openPanel(id) {
    panelStates.value.push(id);
}

function closePanel(id) {
    const index = panelStates.value.findIndex(item => item === id);
    panelStates.value.splice(index, 1);
}

function togglePanel(id) {
    if (isPanelOpen(id)) {
        closePanel(id)
        return;
    }

    openPanel(id)
}

function isPanelOpen(id) {
    return panelStates.value.includes(id);
}
</script>

<template>
    <Head title="Für Schicht anmelden" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">Für Schicht anmelden</h1>
        <form
            class="flex flex-col space-y-4"
            @submit.prevent="handleSubmit"
        >
            <label for="first_name">
                <span class="block">Vorname (*)</span>
                <input
                    v-model="form.first_name"
                    id="first_name"
                    class="w-full rounded-lg"
                    name="first_name"
                    type="text"
                    required
                />
                <span
                    class="text-red-400"
                    v-if="form.errors.first_name"
                    >{{ form.errors.first_name }}</span
                >
            </label>
            <label for="last_name">
                <span class="block">Nachname (*)</span>
                <input
                    v-model="form.last_name"
                    id="last_name"
                    class="w-full rounded-lg"
                    name="last_name"
                    type="text"
                    required
                />
                <span
                    class="text-red-400"
                    v-if="form.errors.last_name"
                    >{{ form.errors.last_name }}</span
                >
            </label>
            <label for="email">
                <span class="block">Email (*)</span>
                <input
                    v-model="form.email"
                    id="email"
                    class="w-full rounded-lg"
                    name="email"
                    type="email"
                    required
                />
                <span
                    class="text-red-400"
                    v-if="form.errors.email"
                    >{{ form.errors.email }}</span
                >
            </label>
            <label for="mobile">
                <span class="block">Mobile (*)</span>
                <input
                    v-model="form.mobile"
                    id="mobile"
                    class="w-full rounded-lg"
                    name="mobile"
                    type="tel"
                    required
                />
                <span
                    class="text-red-400"
                    v-if="form.errors.mobile"
                    >{{ form.errors.mobile }}</span
                >
            </label>
            <label for="shirt_size">
                <span class="block">T-Shirt Größe (*)</span>
                <select
                    v-model="form.shirt_size_id"
                    name="shirt_size"
                    id="shirt_size"
                    class="w-full rounded-lg"
                >
                    <option
                        v-for="size in shirtSizes"
                        :key="size.id"
                        :value="size.id"
                    >
                        {{ size.name.toUpperCase() }}
                    </option>
                </select>
                <span
                    class="text-red-400"
                    v-if="form.errors.shirt_size"
                    >{{ form.errors.shirt_size }}</span
                >
            </label>

            <div class="mt-4" v-for="(shifts, eventTitle) in events">
                <h3 class="text-lg text-center mt-6 mb-2">{{eventTitle}}</h3>
                <div class="flex flex-col space-y-4">
                    <div v-for="shift in shifts" :key="shift.id">
                        <h4 class="bg-gray-200 p-4 cursor-pointer" :class="isPanelOpen(shift.id) ? 'rounded-t-lg' : 'rounded-lg'" @click="togglePanel(shift.id)">{{shift.name}}</h4>
                        <div v-if="isPanelOpen(shift.id)">
                            <fieldset class="bg-gray-100 p-4">
                                <label
                                    :for="time.id"
                                    v-for="time in shift.times"
                                    :key="time.id"
                                    class="block px-4 py-2 border-gray-600 border rounded-lg mb-2"
                                    :class="{'opacity-50': !canSelectShiftTime(time)}"
                                >
                                    <input
                                        v-model="form.selected_shifts"
                                        type="checkbox"
                                        name="race"
                                        :value="time.id"
                                        :id="time.id"
                                        :disabled="!canSelectShiftTime(time)"
                                        class="mr-2"
                                    />
                                    {{ time.label }}
                                    <span class="text-xs">(vergeben {{spotsLookup[time.id] ?? 0}}/{{ time.volunteers_needed }})</span>
                                </label>
                            </fieldset>
                            <div class="shift-description bg-gray-100 rounded-b-lg p-4" v-html="shift.description"></div>
                        </div>
                    </div>
                </div>
            </div>

            <span
                class="text-red-400"
                v-if="form.errors.selected_shifts"
                >{{ form.errors.selected_shifts }}</span
            >
            <button
                type="submit"
                class="bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center disabled:opacity-25"
                :disabled="form.processing"
            >
                <span v-if="!form.processing">Registrieren</span>
                <PacmanLoader
                    v-else
                    color="#fff"
                    class="scale-50"
                />
            </button>
        </form>
    </GuestLayout>
</template>

<style>
.shift-description p {
    @apply mb-4;
}

.shift-description ul {
    @apply list-disc list-outside ml-4;
}
</style>
