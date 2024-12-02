<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CoordonneeRequest extends FormRequest
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
      
        $rules = [
            'numeroCivique' => [
                'required',
                'string',
                'max:8',
                'regex:/^[a-zA-Z0-9]+$/u'
            ],

            'rue' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-zA-Z0-9À-ÿ\'\- ]+$/u'
            ],
            'province' => [
                'required',
                'string',
                'max:64',
            ],

            'bureau' => [
                'nullable',
                'string',
                'max:8',
                'regex:/^[a-zA-Z0-9]+$/u'
            ],

            'codePostale' => [
                'required',
                'string',
                'max:6',
                'regex:/^[a-zA-Z0-9]+$/u'
            ],

            'siteWeb' => [
                'nullable',
                'string',
                'url',
                'max:64'
            ],
            'currentIndex'=>[
                'nullable',
                'integer',
            ],

            'ligne' => ['required', 'array'], 
            'ligne.*.id' => [
                'nullable',
                'integer',
                'exists:telephones,id', 
            ],
            'ligne.*.type' => [
                'required',
                'string',
                Rule::in(['Bureau', 'Télécopieur', 'Cellulaire']), 
            ],
            'ligne.*.numeroTelephone' => [
                'required',
                'string',
                'regex:/^\d{3}-\d{3}-\d{4}$/', 
            ],
            'ligne.*.poste' => [
                'nullable',
                'string',
                'max:6',
                'regex:/^\d+$/', 
            ]
        ];

        // Validation conditionnelle selon la province
        if ($this->input('province') === 'Québec') {
            $rules['municipalite'] = ['required', 'string', 'max:64'];
            $rules['regionAdministrative'] = ['required', 'string'];
        } else {
            $rules['municipaliteInput'] = ['required', 'string', 'max:64'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
      
            'numeroCivique.required' => 'Le numéro civique est requis.',
            'numeroCivique.string' => 'Le numéro civique doit être une chaîne de caractères.',
            'numeroCivique.max' => 'Le numéro civique ne peut pas dépasser 8 caractères.',
            'numeroCivique.regex' => 'Le numéro civique doit contenir uniquement des lettres et des chiffres.',
    
    
            'rue.required' => 'La rue est requise.',
            'rue.string' => 'La rue doit être une chaîne de caractères.',
            'rue.max' => 'La rue ne peut pas dépasser 64 caractères.',
            'rue.regex' => 'La rue peut contenir uniquement des lettres, des chiffres, des espaces, des apostrophes et des tirets.',
    
    
            'province.required' => 'La province est requise.',
    
            'bureau.string' => 'Le bureau doit être une chaîne de caractères.',
            'bureau.max' => 'Le bureau ne peut pas dépasser 8 caractères.',
            'bureau.regex' => 'Le bureau doit contenir uniquement des lettres et des chiffres.',
    
            'codePostale.required' => 'Le code postal est requis.',
            'codePostale.string' => 'Le code postal doit être une chaîne de caractères.',
            'codePostale.max' => 'Le code postal ne peut pas dépasser 6 caractères.',
            'codePostale.regex' => 'Le code postal doit contenir uniquement des lettres et des chiffres.',
    
      
            'siteWeb.string' => 'Le site web doit être une chaîne de caractères.',
            'siteWeb.max' => 'Le site web ne peut pas dépasser 64 caractères.',
            'siteWeb.regex' => 'Le site web doit commencer par "www" et être au format valide (exemple : www.exemple.com).',
    
    
    
            'ligne.required' => 'Les informations de ligne sont requises.',
    
            'ligne.*.type.required' => 'Le type de ligne est requis.',
            'ligne.*.type.string' => 'Le type de ligne doit être une chaîne de caractères.',
            'ligne.*.type.in' => 'Le type de ligne doit être "Bureau", "Télécopieur" ou "Cellulaire".',
    
       
            'ligne.*.numeroTelephone.required' => 'Le numéro de téléphone est requis.',
            'ligne.*.numeroTelephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
    
        
            'ligne.*.poste.string' => 'Le poste doit être une chaîne de caractères.',
            'ligne.*.poste.max' => 'Le poste ne peut pas dépasser 6 caractères.',
            'ligne.*.poste.regex' => 'Le poste doit contenir uniquement des chiffres.',
    
            'municipalite.required' => 'La municipalité est requise.',
    
            'regionAdministrative.required' => 'La région administrative est requise pour les provinces au Québec.',
            'regionAdministrative.string' => 'La région administrative doit être une chaîne de caractères.',
    
    
            'municipaliteInput.required' => 'La municipalité est requise.',
            'municipaliteInput.string' => 'La municipalité doit être une chaîne de caractères.',
            'municipaliteInput.max' => 'La municipalité ne peut pas dépasser 64 caractères.',
        ];
    }
    protected function failedValidation(Validator $validator)
{
    $currentRouteName = $this->route()->getName();

    if ($currentRouteName === 'UpdateCoordonnee') {
        session()->put('errorsCoordonnees', $validator->errors());

        throw new HttpResponseException(
            redirect()->back()
                ->withInput()
        );
    }

    parent::failedValidation($validator);
}

}
