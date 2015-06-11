<?php

namespace App\Http\Requests\demo;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class DemoRequest extends Request
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
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ];
    }

    public function formatErrors(Validator $validator)
    {
        $messages = $validator->messages();

        if ($messages->has('email')) {
            $returnErrors['email'] = $messages->get('email');
        }
        if ($messages->has('password')) {
            $returnErrors['password'] = $messages->get('password');
        }
        return $returnErrors;
    }
}
