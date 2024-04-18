<script setup>
import _ from 'lodash';
import moment from 'moment';
import { computed, ref } from 'vue';
import SkhcInputDate from '@/Components/SkhcInputDate.vue';

const props = defineProps({
    shiftTimes: Array,
    error: String,
});

const model = defineModel({ type: Array });

const filteredShiftTimes = computed(() => {
    return _(props.shiftTimes)
        .filter(
            (shiftTime) =>
                moment(shiftTime.start).format('Y-MM-DD') === selectedDay.value
        )
        .orderBy('start')
        .value();
});

const selectedShiftTimes = computed(() =>
    _(props.shiftTimes)
        .filter((shiftTime) => model.value.includes(shiftTime.id))
        .map(
            (shiftTime) =>
                `${shiftTime.shift} am ${moment(shiftTime.start).format('DD.MM HH:mm')} Uhr`
        )
        .value()
);

const availableDays = _(props.shiftTimes)
    .orderBy((s) => s.start)
    .map((s) => moment(s.start).format('Y-MM-DD'))
    .uniq();

const selectedDay = ref(availableDays.first());

function toggleShiftTime(id) {
    if (!model.value.includes(id)) {
        model.value.push(id);
        return;
    }

    const index = model.value.findIndex((item) => item === id);
    model.value.splice(index, 1);
}

function resetShifts() {
    model.value = [];
}
</script>

<template>
    <div class="space-y-4">
        <SkhcInputDate
            :max="availableDays.last()"
            :min="availableDays.first()"
            label="Wähle einen Tag"
            v-model="selectedDay"
        />
        <div
            :class="{
                'border-blue-500': model.includes(shiftTime.id),
            }"
            @click="toggleShiftTime(shiftTime.id)"
            class="bg-white p-4 border-l-8 shadow rounded cursor-pointer"
            v-for="shiftTime in filteredShiftTimes"
        >
            <div class="flex items-start justify-between">
                <div>
                    <span class="block text-gray-600 font-bold text-lg"
                        >{{ shiftTime.shift }} am
                        {{ moment(shiftTime.start).format('HH:mm') }}
                        Uhr</span
                    >
                    <span class="block text-xs">
                        {{
                            `Geht bis ${moment(shiftTime.end).format('HH:mm')} Uhr` ??
                            '[open end]'
                        }}</span
                    >
                    <span class="block mt-2">{{ shiftTime.comment }}</span>
                </div>
                <span class="text-xs">{{ shiftTime.event }}</span>
            </div>
        </div>
        <div class="flex justify-between items-end">
            <div>
                <span class="block">{{ model.length }} Schichten gewählt</span>
                <ul class="list-disc ml-4">
                    <li v-for="shiftTime in selectedShiftTimes">
                        {{ shiftTime }}
                    </li>
                </ul>
                <span
                    class="block text-red-400 text-sm"
                    v-if="error"
                    >{{ error }}</span
                >
            </div>
            <button
                @click="resetShifts"
                class="text-blue-400 underline"
                type="button"
            >
                Schichten zurücksetzen
            </button>
        </div>
    </div>
</template>
