<?php

namespace App\Services\Auction\Checks;

use App\Services\Auction\Models\Winner;

/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 24.10.23
 * Time: 14:28
 */
interface AuctionCheckInterface
{
    /**
     * @return Winner
     */
    public function findWinner(): Winner;
}