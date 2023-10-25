<?php

namespace App\Services\Auction\Models;

/**
 * Created by PhpStorm.
 * User: Danail Simeonov
 * Date: 24.10.23
 * Time: 14:33
 */
class Winner
{
    private string $name = '';
    private int $winningBid;

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setWinningBid(int $bid): static
    {
        $this->winningBid = $bid;

        return $this;
    }

    public function getWinningBid(): int
    {
        return $this->winningBid;
    }
}