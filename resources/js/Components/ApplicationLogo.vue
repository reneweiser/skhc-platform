<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const logoPath = computed(() => usePage().props.applicationLogo);
</script>
<template>
    <img :src="logoPath" alt="SKHC Logo" />
</template>
