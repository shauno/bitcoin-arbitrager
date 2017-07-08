<?php

namespace App\Mail;

use App\ExchangeRate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class ArbitrageNotification extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Collection
     */
    private $buy;
    /**
     * @var Collection
     */
    private $sell;

    /**
     * Create a new message instance.
     *
     * @param Collection|ExchangeRate[] $buy
     * @param Collection|ExchangeRate[] $sell
     */
    public function __construct(Collection $buy, Collection $sell)
    {
        $this->buy = $buy;
        $this->sell = $sell;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('arbitrage@shauno.co.za')
                    ->view('emails.arbitrage-notification')
                    ->with([
                        'buy' => $this->buy,
                        'sell' => $this->sell,
                    ]);
    }
}
