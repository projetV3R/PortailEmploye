<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactRequest extends FormRequest
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
            'contacts' => ['required', 'array'],
            'contacts.*.prenom' => [
                'required',
                'string',
                'max:32',
                'regex:/^[a-zA-ZÀ-ÿ\'\- ]+$/u'
            ],
            'contacts.*.nom' => [
                'required',
                'string',
                'max:32',
                'regex:/^[a-zA-ZÀ-ÿ\'\- ]+$/u'
            ],
            'contacts.*.fonction' => [
                'nullable',
                'string',
                'max:32'
            ],
            'contacts.*.email' => [
                'required',
                'string',
                'email',
                'max:64'
            ],
            'contacts.*.type' => [
                'required',
                'string',
                Rule::in(['Bureau', 'Télécopieur', 'Cellulaire'])
            ],
            'contacts.*.numeroTelephone' => [
                'required',
                'string',
                'regex:/^\d{3}-\d{3}-\d{4}$/'
            ],
            'contacts.*.poste' => [
                'nullable',
                'string',
                'max:6',
                'regex:/^\d+$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
        
            'contacts.required' => 'Les contacts sont requis.',
    
     
            'contacts.*.prenom.required' => 'Le prénom est requis.',
            'contacts.*.prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'contacts.*.prenom.max' => 'Le prénom ne peut pas dépasser 32 caractères.',
            'contacts.*.prenom.regex' => 'Le prénom ne peut contenir que des lettres, des espaces, des apostrophes et des tirets.',
    
       
            'contacts.*.nom.required' => 'Le nom est requis.',
            'contacts.*.nom.string' => 'Le nom doit être une chaîne de caractères.',
            'contacts.*.nom.max' => 'Le nom ne peut pas dépasser 32 caractères.',
            'contacts.*.nom.regex' => 'Le nom ne peut contenir que des lettres, des espaces, des apostrophes et des tirets.',
    
     
            'contacts.*.fonction.string' => 'La fonction doit être une chaîne de caractères.',
            'contacts.*.fonction.max' => 'La fonction ne peut pas dépasser 32 caractères.',
    
    
            'contacts.*.email.required' => 'L\'adresse courriel est requise.',
            'contacts.*.email.string' => 'L\'adresse courriel doit être une chaîne de caractères.',
            'contacts.*.email.email' => 'L\'adresse courriel doit être une adresse valide.',
            'contacts.*.email.max' => 'L\'adresse courriel ne peut pas dépasser 64 caractères.',
    
            'contacts.*.type.required' => 'Le type de ligne est requis.',
            'contacts.*.type.in' => 'Le  type de ligne  doit être "Bureau", "Télécopieur" ou "Cellulaire".',
    
            'contacts.*.numeroTelephone.required' => 'Le numéro de téléphone est requis.',
            'contacts.*.numeroTelephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
    
    
            'contacts.*.poste.string' => 'Le poste doit être une chaîne de caractères.',
            'contacts.*.poste.max' => 'Le poste ne peut pas dépasser 6 caractères.',
            'contacts.*.poste.regex' => 'Le poste doit contenir uniquement des chiffres.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $currentRouteName = $this->route()->getName();
    
        if ($currentRouteName === 'UpdateContact') {
         
            session()->put('errorsContact', $validator->errors());
    
            throw new HttpResponseException(
                redirect()->back()
                    ->withInput()
            );
        }
    
     
        parent::failedValidation($validator);
    }
    
}
