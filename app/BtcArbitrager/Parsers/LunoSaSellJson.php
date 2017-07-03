<?php

namespace BtcArbitrager\Parsers;

class LunoSaSellJson extends JsonParser
{
    /**
     * @return float
     */
    public function value()
    {
        $volume = 0;

        foreach ($this->content->bids as $bid) {
            $volume += $bid->volume;

            if($volume >= $this->volume) {
                return (float)$bid->price; //TODO, actually average the price over the sum of volumes to get this accurate
            }
        }
    }
}