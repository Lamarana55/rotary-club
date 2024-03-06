<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nom_media' => ['required'],
            'telephone' => 'required|min:9',
            'email'=>'required|email',
            'forme_juridique' => ['required'],
            'logo' => ['image','mimes:png,jpg,jpeg'],
            'description' => 'required|min:20',
            'type_media'=>'required|exists:type_media,id_type_media',
        ];
    }

    public function messages()
    {
        return  [
            'nom_media.required' => 'le nom du média est obligatoire ',
            'telephone.required' => 'le téléphone du média est obligatoire ',
            'email.required' => "l'email du média est obligatoire ",
            'description.required' => "la description du média est obligatoire ",
            'description.min' => "Le texte de description doit contenir au moins 20 caractères",
            'logo' => "Le logo doit être une image"
        ];
    }
}
