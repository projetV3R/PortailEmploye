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
