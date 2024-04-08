<script setup>
import VueFeather from 'vue-feather';
</script>

<template>
    <div
        class="flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50"
        role="alert"
    >
        <VueFeather
            class="flex-shrink-0 inline w-4 h-4 me-3"
            type="alert-triangle"
        />
        <slot />
    </div>
</template>
