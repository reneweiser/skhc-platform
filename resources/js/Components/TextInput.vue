<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    type: String,
    label: String,
    placeholder: String,
    required: {
        type: Boolean,
        default: false,
    },
    name: {
        type: String,
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
            v-if="label"
            :for="name"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >{{ label }}</label
        >
        <input
            :type="type"
            :id="name"
            :name="name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            :placeholder="placeholder"
            :required="required"
        />
    </div>
</template>
