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
