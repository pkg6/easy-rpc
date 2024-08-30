<?php

namespace Pkg6\EasyRPC\HproseHttp;

use Closure;
use Pkg6\EasyRPC\Contracts\Objects;
use Pkg6\EasyRPC\Contracts\Server as ServiceContract;
use Pkg6\EasyRPC\ObjectClass;
use Pkg6\EasyRPC\Validator\HostValidator;
use Pkg6\EasyRPC\Validator\UserValidator;
use ReflectionClass;

class Server extends \Hprose\Http\Server implements ServiceContract
{
    protected $hosts = [];
    protected $users = [];

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
            $ref = ObjectClass::classMethods($objectOrClass);
            $methods = array();
            $aliases = array();
            foreach ($ref as $value) {
                list($new, $method, $methodName) = $value;
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
        $this->users = $authentications;
        return $this;
    }
    public function allowHosts(array $hosts)
    {
        $this->hosts = $hosts;
        return $this;
    }
    public function handle($request = null, $response = null)
    {
        HostValidator::validate($this->hosts, $this->getAttribute('REMOTE_ADDR', null));
        UserValidator::validate($this->users, $this->getUsername(), $this->getPassword());
        parent::handle($request, $response);
    }

    /**
     * Get username
     *
     * @return string
     */
    protected function getUsername()
    {
        return $this->getAttribute('PHP_AUTH_USER', null);
    }

    /**
     * Get password
     *
     * @return string
     */
    protected function getPassword()
    {
        return $this->getAttribute('PHP_AUTH_PW', null);
    }
}