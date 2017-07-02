<?php

namespace BtcArbitrager\Parsers;

use Symfony\Component\DomCrawler\Crawler;

class AltCoinTraderBuyHtml extends HtmlParser
{
    public function value()
    {
        $volume = 0;
        $return = 0;
        $this->content->filter('.orderUdSell')->reduce(function(Crawler $node, $i) use (&$volume, &$return) {
            $price = (float)$node->filter('.orderUdSPr')->text();
            $btc = (float)$node->filter('.orderUdSAm')->text();

            $volume += $price * $btc;

            //TODO, check if there is a better way to return early (or not use reduce maybe)
            if($volume >= $this->volume && !$return) {
                $return =  $price; //TODO, actually average the price over the sum of volumes to get this accurate
            }
        });

        return $return;
    }
}