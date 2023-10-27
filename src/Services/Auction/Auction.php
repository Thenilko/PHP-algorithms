<?php

namespace App\Services\Auction;

use App\Services\Auction\Entity\Bidder;

/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 24.10.23
 * Time: 13:49
 */
class Auction
{
    public array $bidders = [];

    public function __construct(public int $reservePrice)
    {
    }

    public function addBidder(Bidder $bidder)
    {
        $this->bidders[] = $bidder;
    }
}