<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
const emits = defineEmits(['click'])
</script>

<template>
    <button class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
            :type="type"
            @click="emits('click')">
        <slot/>
    </button>
</template>

<style scoped>

</style>
