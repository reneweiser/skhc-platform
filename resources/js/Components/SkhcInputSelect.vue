<script setup>
const props = defineProps({
    label: { type: String },
    options: { type: Array },
    required: { type: Boolean, default: false },
    error: { type: String },
});
const model = defineModel({ type: [Number, String] });
</script>

<template>
    <label class="block text-sm font-medium text-gray-900">
        {{ label }}
        <select
            :required="required"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            v-model="model"
        >
            <option
                :key="option.id"
                :value="option.id"
                v-for="option in options"
            >
                {{ option.name }}
            </option>
        </select>
        <span
            class="block text-red-400 text-sm"
            v-if="error"
            >{{ error }}</span
        >
    </label>
</template>
