<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
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
            :for="name"
            class="block mb-2 text-sm font-medium text-gray-900"
            >{{ label }}</label
        >
        <textarea
            :id="name"
            :placeholder="placeholder"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            ref="input"
            rows="4"
        ></textarea>
    </div>
</template>
