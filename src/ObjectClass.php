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
     * @var string
     */
    public static $PREFIX_PROPERTY_FIELD = 'prefix';


    /**
     * @param ReflectionClass $reflectionClass
     * @return null
     * @throws ReflectionException
     */
    public static function getPrefixPropertyValue(ReflectionClass $reflectionClass)
    {
        if ($reflectionClass->hasProperty(self::$PREFIX_PROPERTY_FIELD)) {
            return $reflectionClass->newInstanceWithoutConstructor()->{self::$PREFIX_PROPERTY_FIELD};
        }
        return null;
    }

    /**
     * @param object $new
     * @param ReflectionClass $reflectionClass
     * @param ReflectionMethod $reflectionMethod
     * @return string
     * @throws ReflectionException
     */
    public static function getAsMethodName($new, ReflectionClass $reflectionClass, ReflectionMethod $reflectionMethod)
    {
        if (!is_null($prefix = self::getPrefixPropertyValue($reflectionClass))) {
            return $prefix . $reflectionMethod->getName();
        }
        return $reflectionClass->getName() . $reflectionMethod->getName();
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
            $asMethod = self::getAsMethodName($new, $ref, $refMethod);
            yield [$new, $asMethod, $methodName];
        }
    }
}