<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'price' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'အမည် ဖြည့်ရန် လိုအပ်ပါသည်။',
            'name.string' => 'အမည်သည် စာသား ဖြစ်ရပါမည်။',
            'price.required' => 'စျေးနှုန်း ဖြည့်ရန် လိုအပ်ပါသည်။',
            'price.numeric' => 'စျေးနှုန်းသည် ဂဏန်း ဖြစ်ရပါမည်။'
        ];
    }
}
