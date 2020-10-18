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
}
