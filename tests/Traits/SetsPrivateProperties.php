<?php

declare(strict_types=1);

namespace Tests\Traits;

use ReflectionClass;

trait SetsPrivateProperties
{
    /**
     * Sets a private property
     *
     * @param mixed $object
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function setPrivateProperty($object, string $property, $value)
    {
        $reflect = new ReflectionClass($object);
        $prop = $reflect->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue($object, $value);
        $prop->setAccessible(false);
    }

    /**
     * Gets a private property
     *
     * @param mixed $object
     * @param string $property
     * @return mixed
     */
    public function getPrivateProperty($object, string $property)
    {
        $reflect = new ReflectionClass($object);
        $prop = $reflect->getProperty($property);
        $prop->setAccessible(true);
        $result = $prop->getValue($object);
        $prop->setAccessible(false);
        return $result;
    }
}
