<script setup>
const props = defineProps({
    label: { type: String },
});
const model = defineModel({ type: Number });
</script>

<template>
    <label class="block text-sm font-medium text-gray-900">
        {{ label }}
        <input
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            type="number"
            v-model="model"
        />
    </label>
</template>
