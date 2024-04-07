<script setup>
import { useForm } from '@inertiajs/vue3';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcInputText from '@/Components/SkhcInputText.vue';
import SkhcInputTextArea from '@/Components/SkhcInputTextArea.vue';
import { marked } from 'marked';
import SkhcInputSelect from '@/Components/SkhcInputSelect.vue';
import SkhcButtonMuted from '@/Components/SkhcButtonMuted.vue';

const props = defineProps({
    events: { type: Array },
    visibilities: Array,
});

const form = useForm({
    name: 'Neue Schicht',
    meeting_place: 'Treffpunkt',
    description: 'Beschreibung',
    event_id: null,
    visibility_id: null,
});

const emits = defineEmits(['submitted']);

function submitForm() {
    form.post(route('shifts.store'), {
        onSuccess: () => emits('submitted'),
    });
}
</script>

<template>
    <form
        @submit.prevent="submitForm"
        class="p-4 flex flex-col space-y-4"
    >
        <SkhcInputSelect
            :error="form.errors.visibility_id"
            :options="visibilities"
            label="Sichtbarkeit"
            required
            v-model="form.visibility_id"
        />

        <SkhcInputSelect
            :error="form.errors.event_id"
            :options="events"
            label="Event"
            required
            v-model="form.event_id"
        />

        <SkhcInputText
            :error="form.errors.name"
            label="Name"
            required
            v-model="form.name"
        />

        <SkhcInputText
            :error="form.errors.meeting_place"
            label="Treffpunkt"
            required
            v-model="form.meeting_place"
        />

        <SkhcInputTextArea
            :error="form.errors.description"
            label="Beschreibung"
            v-model="form.description"
        />

        <span class="block text-sm"
            >Dieses Feld unterstützt Markdown.
            <a
                class="underline text-blue-400"
                href="https://www.markdownguide.org/basic-syntax/"
                >Hier findest du die Grundlagen dafür.</a
            ></span
        >

        <div
            id="preview"
            v-html="marked(form.description)"
        ></div>

        <div class="flex justify-end">
            <SkhcButtonPrimary
                class="disabled:cursor-not-allowed disabled:opacity-50"
                v-if="!form.processing"
                >Erstellen</SkhcButtonPrimary
            >
            <SkhcButtonMuted
                class="disabled:cursor-not-allowed disabled:opacity-50"
                v-if="form.processing"
            >
                Schicht wird erstellt
            </SkhcButtonMuted>
        </div>
    </form>
</template>

<style scoped></style>
