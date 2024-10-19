<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModeleRequest extends FormRequest
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
        'objet' => 'required|string|max:120', 
        'body' => ['required', 'string', function($attribute, $value, $fail) {
            if (trim(strip_tags($value)) === '') {
                $fail('Le champ "contenu" est obligatoire.');
            }
        }],
        'type' => 'nullable|string|max:255', 
        'actif' => 'nullable|boolean', 
    ];
}


    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'objet.required' => 'Le champ "objet" est obligatoire.',
            'objet.string' => 'Le champ "objet" doit être une chaîne de caractères.',
            'objet.max' => 'Le champ "objet" ne peut pas dépasser 120 caractères.',
            
            'body.required' => 'Le champ "contenu" est obligatoire.',
            'body.string' => 'Le champ "contenu" doit être une chaîne de caractères.',
            
            'type.string' => 'Le champ "type" doit être une chaîne de caractères.',
            'type.max' => 'Le champ "type" ne peut pas dépasser 255 caractères.',
            
            'actif.boolean' => 'Le champ "actif" doit être vrai ou faux.',
        ];
    }
}
