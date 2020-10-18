<?php

namespace App\Http\Requests;

use App\Property;
use Illuminate\Foundation\Http\FormRequest;

class ContractStoreRequest extends FormRequest
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
            'name' => 'required',
            'document' => 'required',
            'email' => 'required|email',
            'type_id' => 'required|exists:contract_types,id',
            'property_id' => 'required|exists:properties,id',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // Property can only have one contract
            if ($propertyId = $this->get('property_id')) {
                $property = Property::find($propertyId);

                if ($property && $property->contract()->count()) {
                    $validator->errors()->add('property_id', 'The selected property id already has a contract.');
                }
            }

        });
    }
}