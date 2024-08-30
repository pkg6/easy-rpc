<?php

namespace Pkg6\EasyRPC\HproseHttp;

use Closure;
use Pkg6\EasyRPC\Contracts\Objects;
use Pkg6\EasyRPC\Contracts\Server as ServiceContract;
use Pkg6\EasyRPC\ObjectClass;
use ReflectionClass;

class Server extends \Hprose\Http\Server implements ServiceContract
{
    public function addCallback($method, Closure $callback)
    {
        $this->addFunction($callback, $method);
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
            $methods = array();
            $aliases = array();
            foreach ($ref as $value) {
                list($new, $_, $methodName, $method) = $value;
                $methods[] = $methodName;
                $aliases[] = $method;
            }
            if (isset($new) && !empty($methods) && !empty($aliases)) {
                $this->addMethods($methods, $new, $aliases);
            }
        }
        return $this;
    }

    public function withAuthentications(array $authentications)
    {
        return $this;
    }
}