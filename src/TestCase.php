<?php
/**
 * Common tests stuff
 *
 * @see       https://github.com/sergeymakinen/tests
 * @copyright Copyright (c) 2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/tests/blob/master/LICENSE MIT License
 */

namespace SergeyMakinen\Tests;

use PHPUnit\Framework\Exception;
use PHPUnit\Util\InvalidArgumentHelper;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $expectedException;

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->expectedException = null;
    }

    /**
     * Returns whether the class' parent method exists.
     *
     * @param string $name
     * @return bool
     *
     * @internal
     */
    protected function isParentMethod($name)
    {
        return is_callable('parent::' . $name);
    }

    /**
     * Returns a test double for the specified class.
     *
     * @param string $originalClassName
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMock($originalClassName)
    {
        if ($this->isParentMethod(__FUNCTION__)) {
            return parent::createMock($originalClassName);
        }

        return $this
            ->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->getMock();
    }

    /**
     * Sets an exception expected.
     *
     * @param string $exception
     * @throws Exception|\PHPUnit_Framework_Exception
     */
    public function expectException($exception)
    {
        if ($this->isParentMethod(__FUNCTION__)) {
            parent::expectException($exception);
            return;
        }

        if (!is_string($exception)) {
            if (class_exists('PHPUnit\Util\InvalidArgumentHelper')) {
                throw InvalidArgumentHelper::factory(1, 'string');
            } else {
                throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
            }
        }

        $this->expectedException = $exception;
        $this->setExpectedException($this->expectedException);
    }

    /**
     * Sets an exception code expected.
     *
     * @param int|string $code
     * @throws Exception|\PHPUnit_Framework_Exception
     */
    public function expectExceptionCode($code)
    {
        if ($this->isParentMethod(__FUNCTION__)) {
            parent::expectExceptionCode($code);
            return;
        }

        if (!is_int($code) && !is_string($code)) {
            if (class_exists('PHPUnit\Util\InvalidArgumentHelper')) {
                throw InvalidArgumentHelper::factory(1, 'integer or string');
            } else {
                throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'integer or string');
            }
        }

        $this->setExpectedException($this->expectedException, '', $code);
    }

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
