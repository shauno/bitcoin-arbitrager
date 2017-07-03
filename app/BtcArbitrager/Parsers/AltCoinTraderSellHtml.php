<?php

namespace BtcArbitrager\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class AltCoinTraderSellHtml extends HtmlParser
{
    public function value()
    {
        $volume = 0;
        $return = 0;
        $this->content->filter('.orderUdBuy')->reduce(function(Crawler $node) use (&$volume, &$return) {
            $price = (float)$node->filter('.orderUdBPr')->text();
            $btc = (float)$node->filter('.orderUdBAm')->text();

            $volume += $btc;

            //TODO, check if there is a better way to return early (or not use reduce maybe)
            if($volume >= $this->volume && !$return) {
                $return =  $price; //TODO, actually average the price over the sum of volumes to get this accurate
            }
        });

        return $return;
    }
}