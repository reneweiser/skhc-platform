<script setup>
const props = defineProps({
    label: { type: String },
    error: { type: String },
    required: { type: Boolean, default: false },
    min: { type: String },
    max: { type: String },
});
const model = defineModel({ type: String });
</script>

<template>
    <label class="block text-sm font-medium text-gray-900">
        {{ label }}
        <input
            :max="max"
            :min="min"
            :required="required"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            type="date"
            v-model="model"
        />
        <span
            class="block text-red-400 text-sm"
            v-if="error"
            >{{ error }}</span
        >
    </label>
</template>
