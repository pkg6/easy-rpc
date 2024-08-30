<?php

namespace Pkg6\EasyRPC\Contracts;

use Closure;

interface Server
{
    /**
     * @param $method
     * @param Closure $callback
     * @return $this
     */
    public function addCallback($method, Closure $callback);

    /**
     * @param $objectOrClass
     * @return $this
     */
    public function addObjectClass($objectOrClass);

    /**
     * @param array $authentications
     * @return $this
     */
    public function withAuthentications(array $authentications);

    /**
     * @return mixed
     */
    public function start();
}