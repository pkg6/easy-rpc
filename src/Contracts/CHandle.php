<?php

namespace Pkg6\EasyRPC\Contracts;

interface CHandle
{
    public function handle(Client $client, $method, array $params, $result);
}