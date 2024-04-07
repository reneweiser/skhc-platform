<script setup>
import { useForm } from '@inertiajs/vue3';
import SkhcButtonPrimary from '@/Components/SkhcButtonPrimary.vue';
import SkhcInputText from '@/Components/SkhcInputText.vue';
import SkhcInputTextArea from '@/Components/SkhcInputTextArea.vue';
import { marked } from 'marked';
import SkhcInputSelect from '@/Components/SkhcInputSelect.vue';

const props = defineProps({
    shift: { type: Object },
    events: { type: Array },
    visibilities: { type: Array },
});

const form = useForm({
    name: props.shift.name,
    meeting_place: props.shift.meeting_place,
    description: props.shift.description,
    event_id: props.shift.event_id,
    visibility_id: props.shift.visibility_id,
});

const emits = defineEmits(['updated']);

function submitForm() {
    form.put(route('shifts.update', props.shift), {
        onSuccess: () => emits('close'),
    });
}
</script>

<template>
    <form class="p-4 flex flex-col space-y-4">
        <SkhcInputSelect
            :options="visibilities"
            label="Sichtbarkeit"
            v-model="form.visibility_id"
        />
        <SkhcInputSelect
            :options="events"
            label="Event"
            v-model="form.event_id"
        />
        <SkhcInputText
            label="Name"
            v-model="form.name"
        />
        <SkhcInputText
            label="Treffpunkt"
            v-model="form.meeting_place"
        />
        <SkhcInputTextArea
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
                @click="submitForm"
                class="disabled:cursor-not-allowed disabled:opacity-50"
                type="button"
                >Speichern</SkhcButtonPrimary
            >
        </div>
    </form>
</template>

<style>
#preview > h1 {
    @apply text-xl font-bold;
}
#preview > h2 {
    @apply font-bold;
}
#preview ul {
    @apply list-outside ml-6 list-disc;
}
#preview ol {
    @apply list-outside ml-6 list-decimal;
}
#preview a {
    @apply text-sky-600 underline;
}
#preview strong {
    @apply font-bold;
}
#preview em {
    @apply italic;
}
</style>
