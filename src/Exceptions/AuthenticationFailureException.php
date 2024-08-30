<?php

namespace Pkg6\EasyRPC\Exceptions;

use Exception;

class AuthenticationFailureException extends Exception
{
    public function __construct($message = "Access not allowed")
    {
        parent::__construct($message);
    }
}