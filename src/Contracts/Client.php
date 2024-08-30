<?php

namespace Pkg6\EasyRPC\Contracts;

interface Client
{
    public function withURL($url);

    public function withAuthentication($username, $password);
}