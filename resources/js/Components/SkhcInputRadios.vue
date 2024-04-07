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
        <label
            :for="`${name}-${index}`"
            :key="index"
            class="block"
            v-for="(option, index) in options"
        >
            <input
                :id="`${name}-${index}`"
                :value="option"
                type="radio"
                v-model="model"
            />
            {{ option }}
        </label>
    </div>
</template>

<style scoped></style>
