<?php

namespace App\Http\Requests\Packages;

use Illuminate\Foundation\Http\FormRequest;

class storePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'store_id' => ['required', 'integer', 'exists:stores,id'],
            'client_first_name' => ['required', 'string'],
            'client_last_name' => ['required', 'string'],
            'client_phone' => ['required', 'string'],
            'client_phone2' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'commune_id' => ['required', 'integer', 'exists:communes,id'],
            'delivery_type_id' => ['required', 'integer', 'exists:delivery_types,id'],
            'can_be_opened' => ['boolean'],
            'free_delivery' => ['required', 'boolean'],
            'delivery_price' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_to_pay' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'cod_to_pay' => ['numeric', 'min:0'],
            'commission' => ['numeric', 'min:0'],
            'extra_weight_price' => ['integer', 'min:0'],
            'packaging_price' => ['integer', 'min:0'],
            'partner_cod_price' => ['numeric', 'min:0'],
            'partner_delivery_price' => ['integer', 'min:0'],
            'partner_return' => ['numeric', 'min:0'],
            'return_price' => ['integer', 'min:0'],
            'weight' => ['integer', 'min:0'],
        ];
    }
}
