<?php

namespace Softce\Promua\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as Request;

class PromuaRequest extends Request
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
        $rules = [
            'new_slide' => 'min:1|array',
            'text' => 'array|max:255',
            //'text.'.app()->getLocale() => 'required',
        ];
//        if($this->slide) {
//            $rules['slide'] = 'mimes:jpeg,jpg,png,gif';
//        }

        return $rules;
    }
}
