<?php
/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 24.10.23
 * Time: 14:20
 */

namespace App\Services\Auction\Entities;

interface BidderInterface
{
    public function addBid(int $bid): void;

    public function getName(): string;

    public function getHighestBid(): int;
}