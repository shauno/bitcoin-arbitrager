<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangeRate
 * @property int id
 * @property string tracker_url
 * @property string parser
 * @property Exchange exchange
 * @package App
 */
class ExchangeRate extends Model
{
    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currenctRate()
    {
        return $this->hasMany(CurrentRate::class);
    }

    /**
     *  Getters
     */

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTrackerUrl() : string
    {
        return $this->tracker_url;
    }

    /**
     * @return string
     */
    public function getParser() : string
    {
        return $this->parser;
    }

    /**
     * @return Exchange
     */
    public function getExchange() : Exchange
    {
        return $this->exchange;
    }

    /**
     * Get the latest CurrentRate
     *
     * @return CurrentRate
     */
    public function getCurrentRate()
    {
        return $this->currenctRate()->orderBy('id', 'desc')->first();
    }
}
