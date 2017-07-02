<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangeRate
 * @property int id
 * @property string tracker_url
 * @property string parser
 * @package App
 */
class ExchangeRate extends Model
{
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
}
