<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'surname' => ['required', 'string', 'max:80'],
            'name' => ['required', 'string', 'max:80'],
            'patronymic' => ['nullable', 'string', 'max:80'],
            'phone' => ['required', 'string', 'digits:11'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $requiredPrefix = "Укажите ";
        return [
            'phone.required' => $requiredPrefix . 'телефон',
            'email.required' => $requiredPrefix . 'почту',
            'name.required' => $requiredPrefix . 'имя',
            'surname.required' => $requiredPrefix . 'фамилию',
            'phone.digits' => 'Телефон должен состоять из 11 цифр, например 79001234567.',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен содержать минимум 8 символов.',
        ];
    }
}
