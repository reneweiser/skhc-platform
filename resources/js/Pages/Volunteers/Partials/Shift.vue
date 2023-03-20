<script setup>
defineProps({
    shift: Object
});
</script>

<template>
    <label class="block px-4 py-2 border-gray-600 border rounded-lg mb-2">
        <input type="checkbox" name="race" :value="shift.id" :id="shift.id"
               class="mr-2"
        />
        {{ shift.name }}
    </label>
</template>
