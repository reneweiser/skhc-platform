<script setup>
defineProps({
    title: String,
    name: { required: true, type: String },
    options: Array,
});

const model = defineModel({ type: String });
</script>

<template>
    <div>
        <span class="font-bold">{{ title }}</span>
        <div class="flex flex-wrap space-x-2">
            <label
                :key="index"
                class="block px-2 py-1 bg-white rounded-full cursor-pointer"
                v-for="(option, index) in options"
            >
                <input
                    :value="option.value"
                    class="mr-2"
                    type="radio"
                    v-model="model"
                />
                {{ option.label }}
            </label>
        </div>
    </div>
</template>
