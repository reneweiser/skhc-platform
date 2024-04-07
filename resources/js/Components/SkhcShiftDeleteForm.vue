<script setup>
import { useForm } from '@inertiajs/vue3';
import SkhcButtonDanger from '@/Components/SkhcButtonDanger.vue';
import SkhcButtonMuted from '@/Components/SkhcButtonMuted.vue';
import { ref } from 'vue';

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
            <SkhcButtonDanger
                @click="isReady = true"
                type="button"
            >
                Löschen
            </SkhcButtonDanger>
        </div>
        <form
            @submit.prevent="submit"
            class="border border-red-400 p-2 rounded-lg flex justify-between items-center space-x-8"
            v-if="isReady"
        >
            <div>Bist du sicher?</div>
            <div>
                <SkhcButtonMuted
                    @click="isReady = false"
                    type="button"
                    >Abbrechen</SkhcButtonMuted
                >
                <SkhcButtonDanger> Ja </SkhcButtonDanger>
            </div>
        </form>
    </div>
</template>
