<?php

namespace BtcArbitrager\Parsers;

class LunoSaBuyJson extends JsonParser
{
    /**
     * @return float
     */
    public function value()
    {
        $volume = 0;

        foreach ($this->content->asks as $ask) {
            $volume += $ask->price * $ask->volume;

            if($volume >= $this->volume) {
                return (float)$ask->price; //TODO, actually average the price over the sum of volumes to get this accurate
            }
        }
    }
}