<?php namespace App\Http\Requests;

use App\User;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class PostFormRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check()) {
            return true;
        }
        return false;
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