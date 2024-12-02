<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FinanceRequest extends FormRequest
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
            'numeroTPS' => ['required', 'string', 'regex:/^\d{9}$/'],  // Numéro de TPS (format numérique à 9 chiffres)
            'numeroTVQ' => ['required', 'string', 'regex:/^\d{10}$/'], // Numéro de TVQ (format numérique à 10 chiffres)
            'conditionDePaiement' => ['required', 'string', 'max:255'], // Conditions de paiement
            'devise' => ['required', 'string', Rule::in(['CAD', 'USD'])], // Liste prédéterminée de devises
            'modeCommunication' => ['required', 'string', Rule::in(['courriel','courrier'])], // Liste prédéterminée de modes de communication
        ];
    }

    public function messages(): array
    {
        return [
            'numeroTPS.required' => 'Le numéro de TPS est requis.',
            'numeroTPS.string' => 'Le numéro de TPS doit être une chaîne de caractères.',
            'numeroTPS.regex' => 'Le numéro de TPS doit être un format numérique composé de 9 chiffres.',
    
    
            'numeroTVQ.required' => 'Le numéro de TVQ est requis.',
            'numeroTVQ.string' => 'Le numéro de TVQ doit être une chaîne de caractères.',
            'numeroTVQ.regex' => 'Le numéro de TVQ doit être un format numérique composé de 10 chiffres.',
    
            'conditionDePaiement.required' => 'Les conditions de paiement sont requises.',
    
            'devise.required' => 'La devise est requise.',
    
            'modeCommunication.required' => 'Le mode de communication est requis.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $currentRouteName = $this->route()->getName();
    
        if ($currentRouteName === 'UpdateFinance') {
            session()->put('errorsFinance', $validator->errors());
    
            throw new HttpResponseException(
                redirect()->back()
                    ->withInput()
            );
        }
    
        parent::failedValidation($validator);
    }
}
