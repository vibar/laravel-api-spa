<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    /**
     * Country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
