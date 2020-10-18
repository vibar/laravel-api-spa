<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'street',
        'number',
        'complement',
        'district',
        'city_id',
    ];

    /**
     * City
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->BelongsTo(City::class);
    }

    /**
     * Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
