<?php

namespace App\Http\Requests;

use App\ContractType;
use App\Property;
use Illuminate\Foundation\Http\FormRequest;
use Respect\Validation\Validator as RespectValidator;

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

            // TODO: refactoring

            // Document validation
            if ($typeId = $this->get('type_id')) {
                $type = ContractType::find($typeId);
                $document = $this->get('document');

                if ($document && $type && $type->document_validator) {
                    if (!RespectValidator::{$type->document_validator}()->validate($document)) {
                        $validator->errors()->add('document', 'The selected document is invalid.');
                    }
                }
            }

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
