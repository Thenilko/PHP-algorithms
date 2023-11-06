<?php
/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 6.11.23
 * Time: 13:33
 */

namespace App\Services\Auction;

use App\Services\Auction\Entity\Bidder;

class AuctionManager
{
    /**
     * @param array $bidsData
     * @param Auction $auction
     * @author Danail Simeonov
     */
    public function createBuidders(array $bidsData, Auction $auction): void
    {
        // iterate through bids to create Bidder class which holds name and bids.
        foreach ($bidsData as $bidData) {
            $bidder = new Bidder($bidData['name']);
            if (count($bidData['bids'])) {
                foreach ($bidData['bids'] as $bid) {
                    $bidder->addBid($bid);
                }
            }
            $auction->addBidder($bidder);
        }
    }
}