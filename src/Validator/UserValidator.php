<?php

namespace Pkg6\EasyRPC\Validator;

use Pkg6\EasyRPC\Exceptions\AuthenticationFailureException;

class UserValidator
{
    public static function validate(array $users, $username, $password)
    {
        if (! empty($users) && (! isset($users[$username]) || $users[$username] !== $password)) {
            throw new AuthenticationFailureException('Access not allowed');
        }
    }
}