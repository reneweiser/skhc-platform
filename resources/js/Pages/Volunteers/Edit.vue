<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PacmanLoader from 'vue-spinner/src/PacmanLoader.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    volunteer: Object,
    shirtSizes: Array,
    shifts: Array,
});

const form = useForm({
    first_name: props.volunteer.data.first_name,
    last_name: props.volunteer.data.last_name,
    email: props.volunteer.data.email,
    mobile: props.volunteer.data.mobile,
    shirt_size_id: props.volunteer.data.shirt_size.id,
    selected_shifts: props.volunteer.data.selected_shifts.map(
        (shift) => shift.id
    ),
});

const deleteForm = useForm({
    volunteerId: props.volunteer.data.id,
});

const showModal = ref(false);

const raceShifts = computed(() =>
    props.shifts.filter((item) => item.venue_id === 1)
);
const partyShifts = computed(() =>
    props.shifts.filter((item) => item.venue_id === 2)
);

function handleSubmit() {
    form.put(route('volunteer.update', props.volunteer.data));
}

function handleDeleteRequest() {
    form.delete(route('volunteer.destroy', props.volunteer.data));
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
                        :selected="size.id === form.shirt_size_id"
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
                <span v-if="!form.processing">Speichern</span>
                <PacmanLoader
                    v-else
                    color="#fff"
                    class="scale-50"
                />
            </button>
        </form>

        <button
            @click="showModal = true"
            class="w-full mt-6 bg-white border border-red-600 h-16 text-red-600 font-bold rounded-lg flex justify-center items-center disabled:opacity-25"
        >
            Daten löschen
        </button>

        <Teleport to="body">
            <div
                v-if="showModal"
                class="p-6 fixed top-0 h-screen w-full bg-white flex flex-col justify-center"
            >
                <div class="max-w-screen-sm mx-auto flex flex-col space-y-6">
                    <p class="text-center text-2xl">
                        Bist du sicher, dass du deine Daten löschen willst?
                    </p>
                    <form @submit.prevent="handleDeleteRequest">
                        <button
                            type="submit"
                            :disabled="deleteForm.processing"
                            class="w-full bg-gray-700 h-16 text-white font-bold rounded-lg flex justify-center items-center"
                        >
                            <span v-if="!form.processing"
                                >Ja, bitte lösche meine Daten.</span
                            >
                            <PacmanLoader
                                v-else
                                color="#fff"
                                class="scale-50"
                            />
                        </button>
                    </form>
                    <button
                        @click="showModal = false"
                        class="w-full bg-white border border-red-600 h-16 text-red-600 font-bold rounded-lg flex justify-center items-center"
                    >
                        Nein
                    </button>
                </div>
            </div>
        </Teleport>
    </GuestLayout>
</template>
