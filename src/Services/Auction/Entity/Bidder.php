<?php
/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 24.10.23
 * Time: 14:20
 */

namespace App\Services\Auction\Entity;

class Bidder implements BidderInterface
{
    private array $bids = [];

    public function __construct(private string $name)
    {
    }

    /**
     * @param int $bid
     * @author Danail Simeonov
     */
    public function addBid(int $bid): void
    {
        $this->bids[] = $bid;
    }

    /**
     * @return bool
     * @author Danail Simeonov
     */
    public function hasBids(): bool
    {
        return count($this->bids);
    }

    /**
     * @return string
     * @author Danail Simeonov
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     * @author Danail Simeonov
     */
    public function getHighestBid(): int
    {
        return max($this->bids);
    }
}