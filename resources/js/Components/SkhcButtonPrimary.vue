<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
const emits = defineEmits(['click']);
</script>

<template>
    <button
        :type="type"
        @click="emits('click')"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2"
    >
        <slot />
    </button>
</template>

<style scoped></style>
