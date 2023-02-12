<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PacmanLoader from 'vue-spinner/src/PacmanLoader.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { computed } from 'vue';

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
    shifts: Array,
});

const raceShifts = computed(() =>
    props.shifts.filter((item) => item.venue_id === 1)
);
const partyShifts = computed(() =>
    props.shifts.filter((item) => item.venue_id === 2)
);

function handleSubmit() {
    form.post(route('volunteer.store'));
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
                        {{ size.name }}
                    </option>
                </select>
                <span
                    class="text-red-400"
                    v-if="form.errors.shirt_size"
                    >{{ form.errors.shirt_size }}</span
                >
            </label>
            <fieldset>
                <legend>Schichten für Seifenkistenrennen</legend>
                <label
                    :for="shift.id"
                    v-for="shift in raceShifts"
                    :key="shift.id"
                    class="block px-4 py-2 border-gray-600 border rounded-lg mb-2"
                >
                    <input
                        v-model="form.selected_shifts"
                        type="checkbox"
                        name="race"
                        :value="shift.id"
                        :id="shift.id"
                        class="mr-2"
                    />
                    {{ shift.name }}
                </label>
            </fieldset>

            <fieldset>
                <legend>Schichten für Jubelfeier</legend>
                <label
                    :for="shift.id"
                    v-for="shift in partyShifts"
                    :key="shift.id"
                    class="block px-4 py-2 border-gray-600 border rounded-lg mb-2"
                >
                    <input
                        v-model="form.selected_shifts"
                        type="checkbox"
                        name="party"
                        :value="shift.id"
                        :id="shift.id"
                        class="mr-2"
                    />
                    {{ shift.name }}
                </label>
            </fieldset>
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
