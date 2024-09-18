<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonRequest extends FormRequest
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
            'libelle' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie' => 'required|in:monetaire,produit',
            'status' => 'in:en_attente,approuvé,rejeté',
            'adresse' => 'required|string|max:255',
            'image' => 'nullable|string|max:255', // URL de l'image
        ];
    }
}
