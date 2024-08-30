<?php

namespace Pkg6\EasyRPC\JsonRPCHttp;
use Pkg6\EasyRPC\Contracts\Client as ClientContract;
class Client extends \JsonRPC\Client implements ClientContract
{
    public function withURL($url)
    {
        $this->getHttpClient()->withUrl($url);
        return $this;
    }

    public function withAuthentication($username, $password)
    {
        $this->authentication($username,$password);
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
}