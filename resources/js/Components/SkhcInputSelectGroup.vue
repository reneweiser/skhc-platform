<script setup>
const props = defineProps({
    label: { type: String },
    groups: { type: Array },
});
const model = defineModel({ type: Number });
</script>

<template>
    <label class="block text-sm font-medium text-gray-900 dark:text-white">
        {{ label }}
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            v-model="model"
        >
            <optgroup
                :key="group.id"
                :label="group.name"
                class="text-lg font-bold"
                v-for="group in groups"
            >
                <option
                    :key="option.id"
                    :value="option.id"
                    class="text-base"
                    v-for="option in group.options"
                >
                    {{ option.name }}
                </option>
            </optgroup>
        </select>
    </label>
</template>
