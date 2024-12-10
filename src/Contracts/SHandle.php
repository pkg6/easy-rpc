<?php

namespace Pkg6\EasyRPC\Contracts;

interface SHandle
{
    public function handle(Server $server, $method, array $params, $result);
}