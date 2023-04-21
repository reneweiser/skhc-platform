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
