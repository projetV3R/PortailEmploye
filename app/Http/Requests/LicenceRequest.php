<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class LicenceRequest extends FormRequest
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
            'numeroLicence' => [
                'required_with:statut,typeLicence,sousCategorie',
                'nullable', 
               'regex:/^\d{4}-\d{4}-\d{2}$/' ,// Assure que le format respecte ####-####-##
               //Demander si RBQ est unique ?
            ],
            'statut' => 'required_with:numeroLicence|nullable',
            'typeLicence' => 'required_with:numeroLicence|nullable',
            'sousCategorie' => 'required_with:numeroLicence|array|nullable',
            'sousCategorie.*' => 'integer|exists:sous_categories,id', 
        ];
    }
    
    public function messages(): array
    {
        return [
            'numeroLicence.required_with' => 'Le numéro de licence est obligatoire lorsque le statut, le type de licence ou la sous-catégorie est renseigné.',
            'numeroLicence.regex' => 'Le format du numéro de licence est invalide. Veuillez utiliser le format suivant et respecter qu\'il contient bien 10 chiffres uniquement : ####-####-##.',

            'statut.required_with' => 'Le statut est obligatoire lorsque le numéro de licence est renseigné.',

            'typeLicence.required_with' => 'Le type de licence est obligatoire lorsque le numéro de licence est renseigné.',

            'sousCategorie.required_with' => 'Au moins une sous-catégorie est requise lorsque le numéro de licence est renseigné.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $currentRouteName = $this->route()->getName();
    
        if ($currentRouteName === 'UpdateLicence') {
         
            session()->put('errorsLicence', $validator->errors());
    
            throw new HttpResponseException(
                redirect()->back()
                    ->withInput()
            );
        }
    
     
        parent::failedValidation($validator);
    }
}
