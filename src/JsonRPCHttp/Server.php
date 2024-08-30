<?php

namespace Pkg6\EasyRPC\JsonRPCHttp;

use Closure;
use Pkg6\EasyRPC\Contracts\Objects;
use Pkg6\EasyRPC\Contracts\Server as ServiceContract;
use Pkg6\EasyRPC\ObjectClass;
use ReflectionClass;

class Server extends \JsonRPC\Server implements ServiceContract
{
    public function addCallback($method, Closure $callback)
    {
        $this->getProcedureHandler()->withCallback($method, $callback);
        return $this;
    }

    public function addObjectClass($objectOrClass)
    {
        if (!class_exists($objectOrClass)) {
            return $this;
        }
        if (is_subclass_of($objectOrClass, Objects::class)) {
            (new ReflectionClass($objectOrClass))->newInstanceWithoutConstructor()->register($this);
        } else {
            $ref = ObjectClass::methodCallbacks($objectOrClass);
            foreach ($ref as $value) {
                list($new, $prefix, $methodName, $method) = $value;
                $this->getProcedureHandler()->withClassAndMethod($method, get_class($new), $methodName);
            }
        }
        return $this;
    }

    public function withAuthentications(array $authentications)
    {
        $this->authentication($authentications);
        return $this;
    }


    public function start()
    {
        echo $this->execute();
    }

}