<?php
/**
 * Common tests stuff
 *
 * @see       https://github.com/sergeymakinen/tests
 * @copyright Copyright (c) 2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/tests/blob/master/LICENSE MIT License
 */

namespace SergeyMakinen\Tests\Util;

trait ExtensionTrait
{
    /**
     * Returns the reflected property.
     *
     * @param object|string $object
     * @param string $name
     * @return \ReflectionProperty
     */
    protected function getProperty($object, $name)
    {
        $class = new \ReflectionClass($object);
        while (!$class->hasProperty($name)) {
            $class = $class->getParentClass();
        }
        return $class->getProperty($name);
    }

    /**
     * Returns the private/protected property by its name.
     *
     * @param object|string $object
     * @param string $name
     * @return mixed
     */
    protected function getInaccessibleProperty($object, $name)
    {
        $property = $this->getProperty($object, $name);
        $property->setAccessible(true);
        return $property->getValue(is_object($object) ? $object : null);
    }

    /**
     * Sets the private/protected property value by its name.
     *
     * @param object|string $object
     * @param string $name
     * @param mixed $value
     */
    protected function setInaccessibleProperty($object, $name, $value)
    {
        $property = $this->getProperty($object, $name);
        $property->setAccessible(true);
        $property->setValue(is_object($object) ? $object : null, $value);
    }

    /**
     * Invokes the private/protected method by its name and returns its result.
     *
     * @param object|string $object
     * @param string $name
     * @param array $args
     * @return mixed
     */
    protected function invokeInaccessibleMethod($object, $name, array $args = [])
    {
        $method = new \ReflectionMethod($object, $name);
        $method->setAccessible(true);
        return $method->invokeArgs(is_object($object) ? $object : null, $args);
    }
}
