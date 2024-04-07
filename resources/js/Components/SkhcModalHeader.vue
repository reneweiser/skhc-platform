<script setup>
import VueFeather from 'vue-feather';

const emits = defineEmits(['close']);
</script>

<template>
    <div class="flex justify-end px-2 pt-2 bg-gray-100">
        <button @click="emits('close')">
            <VueFeather
                size="20"
                type="x"
            />
        </button>
    </div>
</template>
