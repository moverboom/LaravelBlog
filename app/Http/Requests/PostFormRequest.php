<?php namespace App\Http\Requests;

use Auth;
use App\User;
use App\Http\Requests\Request;

class PostFormRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //IMPLEMENT USER CHECK LATER
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //IMPLTEMENT BETTER CHECKS LATER
        return [
            'title' => 'required',
            'body' => 'required',
        ];
    }   
}