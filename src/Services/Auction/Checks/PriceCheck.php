<?php

namespace App\Services\Auction\Checks;

use App\Services\Auction\Auction;
use App\Services\Auction\Bidder;
use App\Services\Auction\Exceptions\WinnerNotFoundException;
use App\Services\Auction\Model\Winner;

/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 24.10.23
 * Time: 14:33
 */
class PriceCheck implements AuctionCheckInterface
{
    public function __construct(private Auction $auction)
    {
    }

    /**
     * @inheritDoc
     * @throws WinnerNotFoundException
     */
    public function findWinner(): Winner
    {
        $winner = null;
        $winningPrice = $this->auction->reservePrice;
        $bidders = $this->auction->bidders;

        $totalBidders = count($bidders);
        $currentCountOfBidder = 0;
        /** @var Bidder $bidder */
        foreach ($bidders as $bidder) {
            $currentCountOfBidder++;

            //if the bidder does not have bid we skip him.
            if (!$bidder->hasBids()) {
                continue;
            }

            //taking the biggest bid.
            $highestBid = $bidder->getHighestBid();

            $lastOffer = $totalBidders === $currentCountOfBidder;
            //if he has bigger bid and it`s not last
            //offer we save the winner name and winning price
            if ($highestBid >= $winningPrice) {
                $winner = $bidder->getName();
                if (!$lastOffer) {
                    $winningPrice = $highestBid;
                }

            }
        }

        if (null !== $winner) {
            return (new Winner())->setName($winner)->setWinningBid($winningPrice);
        }

        throw new WinnerNotFoundException();
    }
}