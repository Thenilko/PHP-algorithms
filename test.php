<?php
require 'vendor/autoload.php';

use App\Services\Auction\Auction;
use App\Services\Auction\AuctionManager;
use App\Services\Auction\Checks\PriceCheck;
use App\Services\Auction\Exceptions\AuctionExceptions;

// we create a new Auction instance. with required param reservePrice.
$auction = new Auction(100);

// bids to populate the auction.
$bidsData = [
    [
        'name' => 'A',
        'bids' => [110, 130]
    ],
    [
        'name' => 'B',
        'bids' => []
    ],
    [
        'name' => 'C',
        'bids' => [125]
    ],
    [
        'name' => 'D',
        'bids' => [105, 115, 90]
    ],
    [
        'name' => 'E',
        'bids' => [132, 135, 140]
    ]
];

$auctionManager = new AuctionManager();
$auctionManager->createBuidders($bidsData, $auction);

// we initiate PriceCheck and pass already created auction with the bidders.
$check = new PriceCheck($auction);

// from the check we try to find the winner.
try {
    $result = $check->findWinner();
} catch (AuctionExceptions $exception) {
    echo "{$exception->getMessage()} \n";
    return;
}

echo "Winner: {$result->getName()}\n";
echo "Winning Price: {$result->getWinningBid()} euros\n";