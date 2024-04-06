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
        @click="emits('click')"
        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700"
        type="button"
    >
        <slot />
    </button>
</template>
