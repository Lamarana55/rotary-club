<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestInsertionUser extends FormRequest
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
            'nom'=>'bail| required| min:2| max:20',
            'telephone' => "bail|required|digits:9|unique:user,telephone,$this->id,id",
            'email' => "bail|required|unique:user,email,$this->id,id",
            'prenom'=>'bail|required| min:2| max:50',
            // 'role'=>'bail| required| numeric',
            'adresse'=>'bail|',
            'photo'=>'bail|image|mimes:jpeg,png,jpg,svg'
        ];
    }
}
