<?php

namespace App\Services\Auction\Checks;

use App\Services\Auction\Auction;
use App\Services\Auction\Entities\Bidder;
use App\Services\Auction\Exceptions\MultipleWinnersFoundedException;
use App\Services\Auction\Exceptions\WinnerNotFoundException;
use App\Services\Auction\Models\Winner;

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
     * @throws MultipleWinnersFoundedException
     */
    public function findWinner(): Winner
    {
        $winner = null;
        $highestBids = [];
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
            $highestBids[] = $highestBid;
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

        //see for multiple winners
        if ($this->hasMultipleWinners($highestBids)) {
            throw new MultipleWinnersFoundedException();
        }

        //if the winner is found we create winner object
        if (null !== $winner) {
            return (new Winner())->setName($winner)->setWinningBid($winningPrice);
        }

        throw new WinnerNotFoundException();
    }

    /**
     * @param array $array
     * @return bool
     * @author Danail Simeonov <dsimeonov@parachut.com>
     */
    private function hasMultipleWinners(array $array): bool
    {
        $countValues = array_count_values($array);
        foreach ($countValues as $count) {
            if ($count >= 2) {
                return true;
            }
        }
        return false;
    }
}