import { useForm } from '@inertiajs/vue3';

export function createForm(data) {
    return useForm(data);
}

export function handleAddShiftTime(form, index) {
    form.shift_times.splice(index, 0, {
        label: '08:00-10:00',
        volunteers_needed: 3,
    });
}

export function handleRemoveShiftTime(form, index) {
    if (form.shift_times.length === 1) return;
    form.shift_times.splice(index, 1);
}

export function moveUp(form, index) {
    const tmp = form.shift_times[index];

    if (index <= 1) return;

    form.shift_times.splice(index, 1);
    form.shift_times.splice(index - 1, tmp);
}

export function moveDown(form, index) {
    const tmp = form.shift_times[index];

    if (index >= form.shift_times.length - 1) return;

    form.shift_times.splice(index, 1);
    form.shift_times.splice(index + 1, 0, tmp);
}
