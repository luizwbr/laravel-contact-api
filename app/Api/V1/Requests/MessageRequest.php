<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function rules()
    {
        // 
    }

    public function authorize()
    {
        return true;
    }
}
