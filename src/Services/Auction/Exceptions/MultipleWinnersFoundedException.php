<?php
/**
 * Created by PhpStorm.
 * User: Danail Simeonov - dsimeonov@parachut.com
 * Date: 26.10.23
 * Time: 15:28
 */

namespace App\Services\Auction\Exceptions;

class MultipleWinnersFoundedException extends AuctionExceptions
{
    public function __construct($message = "Multiple winners founded! Business requirement needed!", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}