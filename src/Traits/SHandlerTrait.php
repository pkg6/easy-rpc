<?php

namespace Pkg6\EasyRPC\Traits;

use Pkg6\EasyRPC\Contracts\Server;
use Pkg6\EasyRPC\Contracts\SHandle;

trait SHandlerTrait
{
    /**
     * @var SHandle[]
     */
    protected $handles = [];

    /**
     * @param SHandle $handle
     * @return $this
     */
    public function withHandle(SHandle $handle)
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