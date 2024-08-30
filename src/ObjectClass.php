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
    protected static $methodNamePrefixCallback;

    /**
     * @param callable $fn
     * @return void
     */
    public static function setMethodNamePrefixCallback(callable $fn)
    {
        self::$methodNamePrefixCallback = $fn;
    }

    /**
     * @param $new
     * @param ReflectionClass $reflectionClass
     * @param ReflectionMethod $reflectionMethod
     * @return mixed
     */
    public static function getMethodNamePrefix($new, ReflectionClass $reflectionClass, ReflectionMethod $reflectionMethod)
    {
        if (is_null(self::$methodNamePrefixCallback)) {
            $prefixMethod = 'prefix';
            $fn = function ($object, ReflectionClass $reflectionClass, ReflectionMethod $reflectionMethod) use ($prefixMethod) {
                //默认情况下走类+方法名字(不走namespace)
                $prefix = self::class_basename($object);
                if (method_exists($object, $prefixMethod)) {
                    $prefix = (string)$object->{$prefixMethod}();
                }
                return $prefix;
            };
            self::setMethodNamePrefixCallback($fn);
            self::$FILTER_METHODS = array_merge(self::$FILTER_METHODS, [$prefixMethod]);
        }
        $methodNamePrefixCallback = self::$methodNamePrefixCallback;
        return $methodNamePrefixCallback($new, $reflectionClass, $reflectionMethod);
    }

    /**
     * @param $objectOrClass
     * @return Generator
     * @throws ReflectionException
     */
    public static function methodCallbacks($objectOrClass)
    {
        $ref = new ReflectionClass($objectOrClass);
        $methods = $ref->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $refMethod) {
            $methodName = $refMethod->getName();
            if (in_array($methodName, self::$FILTER_METHODS)) {
                continue;
            }
            $new = $ref->newInstanceWithoutConstructor();
            $prefix = self::getMethodNamePrefix($new, $ref, $refMethod);
            $method = $prefix . $methodName;
            yield [$new, $prefix, $methodName, $method];
        }
    }

    /**
     * @param $class
     * @return string
     */
    public static function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }

    /**
     * @throws ReflectionException
     */
    public static function class_name($class)
    {
        $ref = new ReflectionClass($class);
        return str_replace('\\', '', $ref->getNamespaceName()) . $ref->getShortName();
    }
}