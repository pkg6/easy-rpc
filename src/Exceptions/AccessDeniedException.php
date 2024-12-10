<?php

namespace Pkg6\EasyRPC\Exceptions;

class AccessDeniedException extends \Exception
{
    public function __construct($message = "Access Forbidden")
    {
        parent::__construct($message);
    }
}