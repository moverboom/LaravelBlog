<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class CreateCommentRequest extends Request
{
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
        return [
            'content' => 'required',
            'on_post' => 'required',
            'from_user' => 'required'
        ];
    }
}
