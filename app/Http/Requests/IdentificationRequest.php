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
            
            $rules['numeroEntreprise'] = [
                'nullable',
                'string',
                'size:10',
                'regex:/^(11|22|33|88)\d{8}$/',
                'unique:fiche_fournisseurs,neq,'
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
            // Password
            'password.required' => 'Le mot de passe est requis.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.regex' => 'Le mot de passe doit contenir entre 7 et 12 caractères, avec au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
    
            // Password confirmation
            'password_confirmation.required' => 'La confirmation du mot de passe est requise.',
            'password_confirmation.required_with' => 'La confirmation du mot de passe est requise lorsque le mot de passe est fourni.',
    
            // Email
            'email.required' => 'L\'adresse courriel est requise.',
            'email.string' => 'L\'adresse courriel doit être une chaîne de caractères.',
            'email.email' => 'L\'adresse courriel doit être une adresse valide.',
            'email.max' => 'L\'adresse courriel ne peut pas dépasser 64 caractères.',
            'email.unique' => 'Cette adresse courriel est déjà utilisée.',
    
    
            'numeroEntreprise.nullable' => 'Le numéro d\'entreprise est facultatif.',
            'numeroEntreprise.string' => 'Le numéro d\'entreprise doit être une chaîne de caractères.',
            'numeroEntreprise.size' => 'Le numéro d\'entreprise doit contenir exactement 10 caractères.',
            'numeroEntreprise.regex' => 'Le numéro d\'entreprise doit commencer par "11", "22", "33" ou "88", suivi de chiffres valides.',
            'numeroEntreprise.unique' => 'Ce numéro d\'entreprise est déjà utilisé.',
    
       
            'nomEntreprise.required' => 'Le nom de l\'entreprise est requis.',
            'nomEntreprise.string' => 'Le nom de l\'entreprise doit être une chaîne de caractères.',
            'nomEntreprise.max' => 'Le nom de l\'entreprise ne peut pas dépasser 64 caractères.',
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
