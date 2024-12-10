<?php

namespace Pkg6\EasyRPC\Traits;

use Pkg6\EasyRPC\Contracts\Client as ClientContract;
use Pkg6\EasyRPC\Contracts\CHandle;

trait CHandlerTrait
{
    /**
     * @var CHandle[]
     */
    protected $handles = [];

    /**
     * @param CHandle $handle
     * @return $this
     */
    public function withHandle(CHandle $handle)
    {
        $this->handles[] = $handle;
        return $this;
    }

    /**
     * @param string $method
     * @param array $params
     * @param mixed $result
     * @return void
     */
    protected function runHandles($method, array $params, $result)
    {
        foreach ($this->handles as $handle) {
            $handle->handle($this, $method, $params, $result);
        }
    }
}