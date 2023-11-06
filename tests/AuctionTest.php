<?php

use App\Services\Auction\Auction;
use App\Services\Auction\AuctionManager;
use App\Services\Auction\Checks\PriceCheck;
use App\Services\Auction\Exceptions\AuctionExceptions;
use App\Services\Auction\Exceptions\MultipleWinnersFoundedException;
use App\Services\Auction\Exceptions\WinnerNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 6.11.23
 * Time: 11:20
 */
class AuctionTest extends TestCase {

    /**
     * @var AuctionManager
     * @author Danail Simeonov
     */
    private AuctionManager $auctionManager;

    public function setUp() : void
    {
        $this->auctionManager = new AuctionManager();
    }


    /**
     * @throws WinnerNotFoundException
     * @throws MultipleWinnersFoundedException
     */
    public function testAuctionOk() {
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

        $this->auctionManager->createBuidders($bidsData, $auction);

        // we initiate PriceCheck and pass already created auction with the bidders.
        $check = new PriceCheck($auction);

        $result = $check->findWinner();

        $this->assertEquals('E', $result->getName());
        $this->assertEquals(130, $result->getWinningBid());
    }

    public function testAuctionMultipleWinners() {
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
                'bids' => [112, 15, 130]
            ]
        ];

        $this->auctionManager->createBuidders($bidsData, $auction);

        // we initiate PriceCheck and pass already created auction with the bidders.
        $check = new PriceCheck($auction);

        try {
            $result = $check->findWinner();
        } catch (AuctionExceptions $exception) {
            $this->assertEquals('Multiple winners founded! Business requirement needed!', $exception->getMessage());
        }
    }

    public function testAuctionNoWinner() {
        // we create a new Auction instance. with required param reservePrice.
        $auction = new Auction(100);

        // bids to populate the auction.
        $bidsData = [
            [
                'name' => 'A',
                'bids' => [50, 30]
            ],
            [
                'name' => 'B',
                'bids' => []
            ],
            [
                'name' => 'C',
                'bids' => [20]
            ],
            [
                'name' => 'D',
                'bids' => [50, 18, 90]
            ],
            [
                'name' => 'E',
                'bids' => [63, 23, 84]
            ]
        ];

        $this->auctionManager->createBuidders($bidsData, $auction);

        // we initiate PriceCheck and pass already created auction with the bidders.
        $check = new PriceCheck($auction);

        try {
            $result = $check->findWinner();
        } catch (AuctionExceptions $exception) {
            $this->assertEquals('Winner not found!', $exception->getMessage());
        }
    }
}