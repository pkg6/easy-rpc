<?php

namespace Pkg6\EasyRPC;

use Generator;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ObjectClass
{
    /**
     * @var string[]
     */
    public static $FILTER_METHODS = [
        "__construct",
        "__destruct",
        "__call",
        "__callStatic",
        "__get",
        "__set",
        "__isset",
        "__unset",
        "__sleep",
        "__wakeup",
        "__toString",
        "__invoke",
        "__set_state",
        "__clone"
    ];

    /**
     * @var callable
     */
    protected static $methodNameCallback;

    /**
     * @param callable $fn
     * @return void
     */
    public static function setMethodNameCallback(callable $fn)
    {
        self::$methodNameCallback = $fn;
    }

    /**
     * @param $new
     * @param ReflectionClass $reflectionClass
     * @param ReflectionMethod $reflectionMethod
     * @return mixed
     */
    public static function getMethodName($new, ReflectionClass $reflectionClass, ReflectionMethod $reflectionMethod)
    {
        if (is_null(self::$methodNameCallback)) {
            $prefixMethod = 'prefix';
            $fn = function ($object, ReflectionClass $reflectionClass, ReflectionMethod $reflectionMethod) use ($prefixMethod) {
                //默认情况下走类+方法名字(不走namespace)
                $prefix = self::classBasename($object);
                if (method_exists($object, $prefixMethod)) {
                    $prefix = (string)$object->{$prefixMethod}();
                }
                return $prefix . $reflectionMethod->getName();
            };
            self::setMethodNameCallback($fn);
            self::$FILTER_METHODS = array_merge(self::$FILTER_METHODS, [$prefixMethod]);
        }
        $methodNamePrefixCallback = self::$methodNameCallback;
        return $methodNamePrefixCallback($new, $reflectionClass, $reflectionMethod);
    }

    /**
     * @param $objectOrClass
     * @return Generator
     * @throws ReflectionException
     */
    public static function classMethods($objectOrClass)
    {
        $ref = new ReflectionClass($objectOrClass);
        $methods = $ref->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $refMethod) {
            $methodName = $refMethod->getName();
            if (in_array($methodName, self::$FILTER_METHODS)) {
                continue;
            }
            $new = $ref->newInstanceWithoutConstructor();
            $method = self::getMethodName($new, $ref, $refMethod);
            yield [$new, $method, $methodName];
        }
    }

    /**
     * @param $class
     * @return string
     */
    public static function classBasename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }

    /**
     * @throws ReflectionException
     */
    public static function className($class)
    {
        $ref = new ReflectionClass($class);
        return str_replace('\\', '', $ref->getNamespaceName()) . $ref->getShortName();
    }
}