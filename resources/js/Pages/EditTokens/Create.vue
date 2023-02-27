<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PacmanLoader from 'vue-spinner/src/PacmanLoader.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const form = useForm({
    email: '',
});

function handleSubmit() {
    form.post(route('edit-token.store'));
}
</script>

<template>
    <Head title="Änderungsformular anfordern" />
    <GuestLayout>
        <h1 class="text-xl text-center mb-6">Änderungsformular anfordern</h1>
        <form
            class="flex flex-col space-y-4"
            @submit.prevent="handleSubmit"
        >
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
                <span v-if="!form.processing">Anfordern</span>
                <PacmanLoader
                    v-else
                    color="#fff"
                    class="scale-50"
                />
            </button>
        </form>
    </GuestLayout>
</template>
