<script setup>
import { useForm } from '@inertiajs/vue3';
import SkhcButtonDanger from '@/Components/SkhcButtonDanger.vue';
import SkhcButtonMuted from '@/Components/SkhcButtonMuted.vue';
import { ref } from 'vue';
import SkhcAlertDanger from '@/Components/SkhcAlertDanger.vue';

const props = defineProps({
    shift: { type: Object, required: true },
});

const isReady = ref(false);

const emits = defineEmits(['deleted']);

function submit() {
    useForm({}).delete(route('shifts.destroy', props.shift), {
        onSuccess: () => emits('deleted'),
    });
}
</script>

<template>
    <div>
        <div v-if="!isReady">
            <button
                @click="isReady = true"
                class="text-red-400 underline"
                type="button"
            >
                Löschen
            </button>
        </div>
        <SkhcAlertDanger v-if="isReady">
            <form
                @submit.prevent="submit"
                class="w-full flex justify-between items-center space-x-8"
            >
                <div>Bist du sicher?</div>
                <div>
                    <SkhcButtonMuted
                        @click="isReady = false"
                        type="button"
                        >Nein</SkhcButtonMuted
                    >
                    <SkhcButtonDanger> Ja </SkhcButtonDanger>
                </div>
            </form>
        </SkhcAlertDanger>
    </div>
</template>
