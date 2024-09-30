<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParametreSystemeRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'cle' => 'required|in:email_approvisionnement,finance_approvisionnement,taille_fichier,mois_revision',
        ];

        // Utilisation de if pour définir les règles spécifiques selon la clé
        if ($this->input('cle') === 'email_approvisionnement' || $this->input('cle') === 'finance_approvisionnement') {
            $rules['valeur'] = 'required|email';  
        }

        if ($this->input('cle') === 'taille_fichier') {
            $rules['valeur_numerique'] = 'required|integer|max:75';  
        }

        if ($this->input('cle') === 'mois_revision') {
            $rules['valeur_numerique'] = 'required|integer|max:36'; 
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'valeur.required' => 'La valeur est obligatoire.',
            'valeur.email' => 'La valeur doit être une adresse email valide.',
            'valeur_numerique.required' => 'La valeur numérique est obligatoire.',
            'valeur_numerique.integer' => 'La valeur doit être un entier.',
            'valeur_numerique.max' => 'La valeur ne peut pas dépasser :max.',
        ];
    }
}
