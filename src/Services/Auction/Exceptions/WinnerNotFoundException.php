<?php
/**
 * Created by PhpStorm.
 * User: Danail Simeonov - dsimeonov@parachut.com
 * Date: 25.10.23
 * Time: 20:57
 */

namespace App\Services\Auction\Exceptions;

class WinnerNotFoundException extends AuctionExceptions
{
    public function __construct($message = "Winner not found!", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
