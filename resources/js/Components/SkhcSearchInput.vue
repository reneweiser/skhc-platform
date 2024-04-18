<script setup>
const model = defineModel({ type: String });
</script>

<template>
    <div>
        <label
            class="mb-2 text-sm font-medium text-gray-900 sr-only"
            for="search-input"
            >Search</label
        >
        <div class="relative">
            <div
                class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
            >
                <svg
                    aria-hidden="true"
                    class="w-4 h-4 text-gray-500"
                    fill="none"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                    />
                </svg>
            </div>
            <input
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                id="search-input"
                placeholder="Suche"
                type="search"
                v-model="model"
            />
        </div>
    </div>
</template>

<style scoped></style>
