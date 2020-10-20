<?php

namespace App\Http\Requests;

use App\Exceptions\MyException;
use App\Rules\UserDuplicate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\DatabaseManager as DB;

class SignUpRequest extends FormRequest
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
     * @return array
     */
    public function rules(UserDuplicate $userDuplicate)
    {
        return  [
            'name'     => 'required',
            'password' => 'required',
            'email'    => ['required', 'email', $userDuplicate]
        ];
    }

    public function messages()
    {
        return [
            'required'    => 'required',
            'required_if' => 'required',
            'isset'       => 'required',
            'exists'      => 'invalid',
            'exists_join' => 'invalid',
            'in'          => 'invalid',
            'array'       => 'invalid',
            'string'      => 'invalid',
            'integer'     => 'invalid',
            'numeric'     => 'invalid',
            'min'         => 'invalid',
            'email'       => 'invalid'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new MyException('illegal_form_input', 403, ['validation' => $validator->errors()]);
    }
}
