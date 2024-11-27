<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ParametreSysteme;

class BrochureCarteAffaireRequest extends FormRequest
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
            'fichiers' => 'required|array',
            'fichiers.*' => 'required|file|mimes:doc,docx,pdf,jpg,jpeg,xls,xlsx|max:10240', 
        ];
    }


    public function withValidator($validator)
    {
    
        $maxFileSizeInMB = ParametreSysteme::where('cle', 'taille_fichier')->value('valeur_numerique'); 

        if ($maxFileSizeInMB) {
            $maxTotalSizeInBytes = $maxFileSizeInMB * 1024 * 1024; 

            $validator->after(function ($validator) use ($maxTotalSizeInBytes) {
                $totalSize = 0;

          
                if ($this->hasFile('fichiers')) {
                    foreach ($this->file('fichiers') as $key => $file) {
                        $taille = $file->getSize(); 
                        $totalSize += $taille;

                  
                        $this->merge([
                            "fichiers.$key.taille" => $taille,
                        ]);
                    }
                }

               
                if ($totalSize > $maxTotalSizeInBytes) {
                    $validator->errors()->add('fichiers', 'La taille totale des fichiers dépasse la limite autorisée de ' . ($maxTotalSizeInBytes / (1024 * 1024)) . ' Mo.');
                }
            });
        } else {
            $validator->errors()->add('fichiers', 'La taille maximale autorisée des fichiers n\'est pas définie.');
        }
    }
}
