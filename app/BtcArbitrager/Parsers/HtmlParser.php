<?php

namespace BtcArbitrager\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class HtmlParser
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
        $this->content = new Crawler($content);
        $this->volume = $volume;
    }
}