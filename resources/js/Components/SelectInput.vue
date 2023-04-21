<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String | Number,
    label: String,
    required: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div>
        <label
            :for="name"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >{{ label }}</label
        >
        <select
            :id="name"
            :name="name"
            :value="modelValue"
            :required="required"
            ref="input"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option
                v-for="option in options"
                :key="option.id"
                :value="option.id"
            >
                {{ option.name }}
            </option>
        </select>
    </div>
</template>
