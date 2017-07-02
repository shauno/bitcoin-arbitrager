<?php

namespace BtcArbitrager\Parsers;

abstract class JsonParser
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var float
     */
    protected $volume;

    /**
     * @param string $content
     * @param float $volume
     */
    public function __construct(string $content, float $volume)
    {
        $this->content = \json_decode($content);
        $this->volume = $volume;
    }

    /**
     * @return float
     */
    abstract public function value();
}