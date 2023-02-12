<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVolunteerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:volunteers,email'],
            'mobile' => ['required', 'string'],
            'shirt_size_id' => ['required', 'exists:shirt_sizes,id'],
            'selected_duties' => 'required|array',
            'selected_duties.*' => 'exists:duties,id',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Vorname ist Pflichtfeld.',
            'last_name.required' => 'Nachname ist Pflichtfeld.',
            'email.required' => 'Email ist Pflichtfeld.',
            'email.unique' => 'Diese Email ist schon vorhanden.',
            'mobile.required' => 'Mobile ist Pflichtfeld.',
            'shirt_size.required' => 'T-Shirt Größe ist Pflichtfeld.',
            'selected_duties.required' => 'Du musst dich für mindestens eine Schicht melden.',
        ];
    }
}
