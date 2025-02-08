<?php

namespace App\Exceptions;

use Exception;

class SubscriptionNotFoundException extends Exception
{
    public function __construct($message = "Subscription not found.", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
