<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class IdentificationRequest extends FormRequest
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
        $currentRouteName = $this->route()->getName();

        // Règles communes à toutes les routes


        if ($currentRouteName === 'UpdateIdentification') {

            $rules['password'] = [
                'nullable',
                'string',
                'min:7',
                'max:12',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{7,12}$/',
                'confirmed',
            ];

            $rules['password_confirmation'] = [
                'required_with:password',
            ];

            $rules['email'] = [
                'required',
                'string',
                'email',
                'max:64',
                'unique:fiche_fournisseurs,adresse_courriel,' . $this->user()->id,
            ];
        } else {

            $rules['password'] = [
                'required',
                'string',
                'min:7',
                'max:12',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{7,12}$/',
                'confirmed',
            ];
            $rules['password_confirmation'] = [
                'required',
            ];

            $rules = [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:64',
                    'unique:fiche_fournisseurs,adresse_courriel,'
                ],
                'numeroEntreprise' => [
                    'nullable',
                    'string',
                    'size:10',
                    'regex:/^(11|22|33|88)\d{8}$/',
                    'unique:fiche_fournisseurs,neq,'
                ],
                'nomEntreprise' => [
                    'required',
                    'string',
                    'max:64'
                ],
            ];
        }

        return $rules;
    }


    /**
     * 
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.regex' => 'Le mot de passe doit contenir entre 7 et 12 caractères, avec au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
            'numeroEntreprise.regex' => 'Le numéro d\'entreprise doit commencer par "11", "22", "33" ou "88", suivi d\'un chiffre entre 4 et 9, puis de 7 autres chiffres.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $currentRouteName = $this->route()->getName();

        if ($currentRouteName === 'UpdateIdentification') {

            session()->put('errorsId', $validator->errors());

            throw new HttpResponseException(
                redirect()->back()
                    ->withInput()
            );
        }


        parent::failedValidation($validator);
    }
}
