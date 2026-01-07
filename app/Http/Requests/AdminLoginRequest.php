<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Frontend currently sends `email`.
            // We also allow `username` as an alternative.
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');
            $username = $this->input('username');

            if (! $email && ! $username) {
                $validator->errors()->add('email', 'Either email or username is required.');
            }
        });
    }
}
