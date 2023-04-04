<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p>
                        Du kannst hier die Daten aller Helfer <a class="font-bold underline hover:text-sky-400" :href="route('volunteers.download')">herunterladen</a>.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
