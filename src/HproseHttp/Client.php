<?php

namespace Pkg6\EasyRPC\HproseHttp;

use Pkg6\EasyRPC\Contracts\Client as ClientContract;
class Client extends \Hprose\Http\Client implements ClientContract
{

    public function __construct($uris = null, $async = false)
    {
        parent::__construct($uris, $async);
    }

    public function withURL($url)
    {
        $this->setUriList($url);
        return $this;
    }

    public function withAuthentication($username, $password)
    {
        return $this;
    }
}