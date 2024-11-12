<?php

namespace App\Http\Requests\Packages;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'storeId' => ['integer', 'exists:stores,id'],
            'wilayaId' => ['integer', 'exists:wilayas,id'],
            'communeId' => ['integer', 'exists:communes,id'],
            'deliveryTypeId' => ['integer', 'exists:delivery_types,id'],
            'packageStatusId' => ['integer', 'exists:package_statuses,id'],
            'trackingCode' => ['string'],
            'export' => ['string'],
        ];
    }
}
