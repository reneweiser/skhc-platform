<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import PacmanLoader from 'vue-spinner/src/PacmanLoader.vue';
import Modal from '@/Components/Modal.vue';
import { groupBy } from 'lodash';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    volunteer: Object,
    shirtSizes: Array,
    shifts: Object,
    spots: Array,
});

const form = useForm({
    first_name: props.volunteer.data.first_name,
    last_name: props.volunteer.data.last_name,
    email: props.volunteer.data.email,
    mobile: props.volunteer.data.mobile,
    shirt_size_id: props.volunteer.data.shirt_size.id,
    selected_shifts: props.volunteer.data.selected_shifts.map(
        (item) => item.id
    ),
});

const events = groupBy(props.shifts.data, (shift) => shift.event_name);

const panelStates = ref([]);
const showDeleteModal = ref(false);

function handleSubmit() {
    form.put(route('admin.volunteer.update', props.volunteer.data));
}

function handleDelete() {
    router.delete(route('admin.volunteer.destroy', props.volunteer.data));
}

function canSelectShiftTime(shiftTime) {
    if (shiftTime.needs_more_volunteers) return true;

    return form.selected_shifts.includes(shiftTime.id);
}

function openPanel(id) {
    panelStates.value.push(id);
}

function closePanel(id) {
    const index = panelStates.value.findIndex((item) => item === id);
    panelStates.value.splice(index, 1);
}

function togglePanel(id) {
    if (isPanelOpen(id)) {
        closePanel(id);
        return;
    }

    openPanel(id);
}

function isPanelOpen(id) {
    return panelStates.value.includes(id);
}
</script>

<template>
    <Head title="Helfer ändern" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Helfer ändern
            </h2>
        </template>
        <div class="py-12">
            <div
                id="sections"
                class="sm:px-2"
            >
                <section
                    class="sm:max-w-screen-sm mx-auto p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
                >
                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            @click="showDeleteModal = true"
                            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                        >
                            Daten löschen
                        </button>
                    </div>

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

                        <div
                            class="mt-4"
                            v-for="(shifts, eventTitle) in events"
                        >
                            <h3 class="text-lg text-center mt-6 mb-2">
                                {{ eventTitle }}
                            </h3>
                            <div class="flex flex-col space-y-4">
                                <div
                                    v-for="shift in shifts"
                                    :key="shift.id"
                                >
                                    <h4
                                        class="bg-gray-200 p-4 cursor-pointer"
                                        :class="
                                            isPanelOpen(shift.id)
                                                ? 'rounded-t-lg'
                                                : 'rounded-lg'
                                        "
                                        @click="togglePanel(shift.id)"
                                    >
                                        {{ shift.name }}
                                    </h4>
                                    <div v-if="isPanelOpen(shift.id)">
                                        <fieldset class="bg-gray-100 p-4">
                                            <label
                                                :for="time.id"
                                                v-for="time in shift.times"
                                                :key="time.id"
                                                class="block px-4 py-2 border-gray-600 border rounded-lg mb-2"
                                                :class="{
                                                    'opacity-50':
                                                        !canSelectShiftTime(
                                                            time
                                                        ),
                                                }"
                                            >
                                                <input
                                                    v-model="
                                                        form.selected_shifts
                                                    "
                                                    type="checkbox"
                                                    name="race"
                                                    :value="time.id"
                                                    :id="time.id"
                                                    :disabled="
                                                        !canSelectShiftTime(
                                                            time
                                                        )
                                                    "
                                                    class="mr-2"
                                                />
                                                {{ time.label }}
                                                <span class="text-xs"
                                                    >(vergeben
                                                    {{ time.spots_filled }}/{{
                                                        time.volunteers_needed
                                                    }})</span
                                                >
                                            </label>
                                        </fieldset>
                                        <div
                                            class="shift-description bg-gray-100 rounded-b-lg p-4"
                                            v-html="shift.description"
                                        ></div>
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
                            <span v-if="!form.processing">Speichern</span>
                            <PacmanLoader
                                v-else
                                color="#fff"
                                class="scale-50"
                            />
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal
        :show="showDeleteModal"
        @close="showDeleteModal = false"
    >
        <div class="p-6">
            <p class="mb-6 text-xl text-center">
                Bist du sicher, dass du die Daten von
                <span class="font-bold"
                    >{{ volunteer.data.first_name }}
                    {{ volunteer.data.last_name }}</span
                >
                unwiderruflich löschen willst?
            </p>
            <div class="flex justify-end">
                <button
                    type="submit"
                    @click="handleDelete"
                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                >
                    Ja, jetzt löschen
                </button>
            </div>
        </div>
    </Modal>
</template>

<style>
.shift-description p {
    @apply mb-4;
}

.shift-description ul {
    @apply list-disc list-outside ml-4;
}
</style>
