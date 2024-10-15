<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsagerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>'required|email|unique:usagers,email',
            'password'=>'required|min:6|confirmed',
            'nom'=>'required|string|',
            'prenom'=>'required|string|',
            'role'=>'required|in:admin,responsable,commis'
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => '1',
            'email.email' => 'Informations invalides.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'nom.required' => 'Le champ nom est obligatoire.',
            'prenom.required' => 'Le champ prénom est obligatoire.',
            'nom.string' => 'Le champ nom est obligatoirement en caratère.',
            'prenom.string' => 'Le champ prénom est obligatoire  en caratère.',
            'role.required' => 'Le champ rôle est obligatoire.',
        ];
    }
}
