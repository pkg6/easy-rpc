<?php

namespace Pkg6\EasyRPC\Contracts;

use Closure;

interface Server
{
    /**
     * Callback binding:
     * @param $method
     * @param Closure $callback
     * @return $this
     */
    public function addCallback($method, Closure $callback);

    /**
     * Class/Method binding:
     * @param $objectOrClass
     * @return $this
     */
    public function addObjectClass($objectOrClass);

    /**
     * List of users to allow
     * @param array $authentications
     * @return $this
     */
    public function withAuthentications(array $authentications);

    /**
     * IP client restrictions
     * @param array $hosts
     * @return $this
     */
    public function allowHosts(array $hosts);

    /**
     * @return mixed
     */
    public function start();
}