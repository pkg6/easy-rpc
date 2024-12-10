<?php

namespace Pkg6\EasyRPC\JsonRPCHttp;

use Pkg6\EasyRPC\Contracts\Client as ClientContract;
use Pkg6\EasyRPC\Traits\CHandlerTrait;

class Client extends \JsonRPC\Client implements ClientContract
{
    use CHandlerTrait;

    public function withURL($url)
    {
        $this->getHttpClient()->withUrl($url);
        return $this;
    }

    public function withAuthentication($username, $password)
    {
        $this->authentication($username, $password);
        return $this;
    }

    public function withTimeout($timeout)
    {
        $this->getHttpClient()->withTimeout($timeout);
        return $this;
    }

    public function withDebug()
    {
        $this->getHttpClient()->withDebug();
        return $this;
    }

    public function __call($method, array $params)
    {
        $result = parent::__call($method, $params);
        $this->runHandles($method, $params, $result);
        return $result;
    }
}