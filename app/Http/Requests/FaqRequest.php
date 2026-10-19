<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{

public function authorize():bool
{
    return true;
}


public function rules():array
{
    return [

        'question'=>'required',

        'answer'=>'required',

        'common_id'=>'required',

        'common_type'=>'required',

        'sort_order'=>'nullable|integer',

        'is_active'=>'nullable'

    ];
}

}
