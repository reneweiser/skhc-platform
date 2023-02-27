<?php

namespace App\Http\Requests;

use App\Mail\VolunteerCreated;
use App\Models\Volunteer;
use App\Models\VolunteerVerificationToken;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;

class UpdateVolunteerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'mobile' => ['required', 'string'],
            'shirt_size_id' => ['required', 'exists:shirt_sizes,id'],
            'selected_shifts' => 'required|array',
            'selected_shifts.*' => 'exists:shifts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Vorname ist Pflichtfeld.',
            'last_name.required' => 'Nachname ist Pflichtfeld.',
            'email.required' => 'Email ist Pflichtfeld.',
            'mobile.required' => 'Mobile ist Pflichtfeld.',
            'shirt_size.required' => 'T-Shirt Größe ist Pflichtfeld.',
            'selected_shifts.required' => 'Du musst dich für mindestens eine Schicht melden.',
        ];
    }

    public function persist(Volunteer $volunteer)
    {
        $volunteer->update($this->safe()->except('selected_shifts'));

        $volunteer->assign($this->safe()->only('selected_shifts')['selected_shifts']);
    }
}
