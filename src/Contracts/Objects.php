<?php

namespace Pkg6\EasyRPC\Contracts;

interface Objects
{
    /**
     * 注入方法
     * @param Server $server
     * @return mixed
     * @see https://packagist.org/packages/fguillot/json-rpc
     * @see https://github.com/hprose/hprose-php/wiki/06-Hprose-%E6%9C%8D%E5%8A%A1%E5%99%A8
     */
    public function register(Server &$server);
}