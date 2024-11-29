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
