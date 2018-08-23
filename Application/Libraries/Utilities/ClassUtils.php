<?php

namespace Libraries\Utilities;

class ClassUtils
{

    /**
     * @param $argument
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    public static function getReflectionClass($argument): \ReflectionClass
    {
        return new \ReflectionClass($argument);
    }

    /**
     * Get class name
     * @param $argument
     * @return string
     * @throws \ReflectionException
     */
    public static function getName($argument): string
    {
        return self::getReflectionClass($argument)->getName();
    }

    /**
     * Get class short name
     * @param $argument
     * @return string
     * @throws \ReflectionException
     */
    public static function getShortName($argument): string
    {
        return self::getReflectionClass($argument)->getShortName();
    }

    /**
     * Get class namespace
     * @param $argument
     * @return string
     * @throws \ReflectionException
     */
    public static function getNamespace($argument): string
    {
        return self::getReflectionClass($argument)->getNamespaceName();
    }

    /**
     * Get class properties
     * @param $argument
     * @param string $types
     * @return array
     * @throws \ReflectionException
     */
    public static function getProperties($argument, string $types = 'public'): array
    {
        $properties = self::getReflectionClass($argument)->getProperties();
        $propertiesArray = [];

        foreach ($properties as $property) {
            if ($property->isPublic() and (stripos($types, 'public') === false)) continue;
            if ($property->isPrivate() and (stripos($types, 'private') === false)) continue;
            if ($property->isProtected() and (stripos($types, 'protected') === false)) continue;
            if ($property->isStatic() and (stripos($types, 'static') === false)) continue;

            $propertiesArray[$property->getName()] = $property;
        }

        return $propertiesArray;
    }

    /**
     * Call setters
     * @param $object
     * @param array $properties [property => value, [...]]
     */
    public static function callSetters($object, array $properties)
    {
        foreach ($properties as $property => $value) {
            $setterName = 'set' . StringUtils::convertToStudlyCaps($property);

            if (method_exists($object, $setterName)) {
                call_user_func([$object, $setterName], $value);
            }
        }
    }

}