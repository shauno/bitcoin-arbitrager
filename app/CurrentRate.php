<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrentRate
 * @package App
 */
class CurrentRate extends Model
{
    protected $fillable = [
        'rate',
    ];

    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }

    /**
     * Getters
     */
}
