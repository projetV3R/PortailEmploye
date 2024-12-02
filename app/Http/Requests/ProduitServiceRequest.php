<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProduitServiceRequest extends FormRequest
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
            'details_specifications' => 'required',
            'produits_services' => 'required|array',
            'produits_services.*' => 'integer|exists:produits_services,id', 
            
        ];
    }

    public function messages()
    {
        return [
            'details_specifications.required' => 'Les spécifications détaillées sont requises.',
            'details_specifications.string' => 'Les spécifications détaillées doivent être une chaîne de caractères valide.',
            'details_specifications.max' => 'Les spécifications détaillées ne peuvent pas dépasser 500 caractères.',

            'produits_services.required' => 'Les produits ou services doivent être fournis.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $currentRouteName = $this->route()->getName();
    
        if ($currentRouteName === 'UpdateProduit') {
         
            session()->put('errorsPS', $validator->errors());
    
            throw new HttpResponseException(
                redirect()->back()
                    ->withInput()
            );
        }
    
     
        parent::failedValidation($validator);
    }
}
