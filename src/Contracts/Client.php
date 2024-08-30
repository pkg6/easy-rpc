<?php

namespace Pkg6\EasyRPC\Contracts;

interface Client
{
    /**
     * @param $url
     * @return $this
     */
    public function withURL($url);

    /**
     * @param $timeout
     * @return $this
     */
    public function withTimeout($timeout);

    /**
     * @return $this
     */
    public function withDebug();

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    public function withAuthentication($username, $password);
}