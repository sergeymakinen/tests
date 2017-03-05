<?php

namespace SergeyMakinen\Tests;

use SergeyMakinen\Tests\Stubs\Class2;

/**
 * @coversDefaultClass \SergeyMakinen\Tests\TestCase
 * @covers ::<private>
 */
class TestCaseTest extends TestCase
{
    /**
     * @var array
     */
    protected $isParentMethodOverriden = [];

    /**
     * @covers ::isParentMethod
     */
    public function testIsParentMethod()
    {
        $this->assertTrue($this->isParentMethod('getExpectedException'));
        $this->assertFalse($this->isParentMethod(__FUNCTION__));
    }

    /**
     * @covers ::createMock
     */
    public function testCreateMock()
    {
        $expected = $this
            ->getMockBuilder('SergeyMakinen\Tests\Stubs\Class1')
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning();
        if (method_exists($expected, 'disallowMockingUnknownTypes')) {
            $expected->disallowMockingUnknownTypes();
        }
        $expected = $expected->getMock();
        $this->executeOverriddenAndParentMethod('createMock', function () use ($expected) {
            $this->assertEquals($expected, $this->createMock('SergeyMakinen\Tests\Stubs\Class1'));
        });
    }

    /**
     * @covers ::expectException
     */
    public function testOverriddenExpectException()
    {
        if (!method_exists($this, 'setExpectedException')) {
            $this->markTestSkipped('PHPUnit\Framework\TestCase::setExpectedException() does not exist.');
            return;
        }

        $this->isParentMethodOverriden = ['expectException' => false];
        $this->expectException('RuntimeException');
        throw new \RuntimeException();
    }

    /**
     * @covers ::expectException
     */
    public function testOverriddenExpectExceptionError()
    {
        $this->isParentMethodOverriden = ['expectException' => false];
        $exception = null;
        try {
            $this->expectException([]);
        } catch (\RuntimeException $e) {
            $exception = $e;
        }
        if (class_exists('PHPUnit\Framework\Exception')) {
            $this->assertInstanceOf('PHPUnit\Framework\Exception', $exception);
        } else {
            $this->assertInstanceOf('PHPUnit_Framework_Exception', $exception);
        }
    }

    /**
     * @covers ::expectException
     */
    public function testParentExpectException()
    {
        if (!parent::isParentMethod('expectException')) {
            $this->markTestSkipped('PHPUnit\Framework\TestCase::expectException() does not exist.');
            return;
        }

        $this->isParentMethodOverriden = ['expectException' => true];
        $this->expectException('RuntimeException');
        throw new \RuntimeException();
    }

    /**
     * @covers ::expectExceptionCode
     * @covers ::tearDown
     */
    public function testOverriddenExpectExceptionCode()
    {
        if (!method_exists($this, 'setExpectedException')) {
            $this->markTestSkipped('PHPUnit\Framework\TestCase::setExpectedException() does not exist.');
            return;
        }

        $this->isParentMethodOverriden = [
            'expectException' => false,
            'expectExceptionCode' => false,
        ];
        $this->expectException('\RuntimeException');
        $this->expectExceptionCode(41);
        throw new \RuntimeException('', 41);
    }

    /**
     * @covers ::expectExceptionCode
     * @covers ::tearDown
     */
    public function testOverriddenExpectExceptionCodeError()
    {
        $this->isParentMethodOverriden = ['expectExceptionCode' => false];
        $exception = null;
        try {
            $this->expectExceptionCode([]);
        } catch (\RuntimeException $e) {
            $exception = $e;
        }
        if (class_exists('PHPUnit\Framework\Exception')) {
            $this->assertInstanceOf('PHPUnit\Framework\Exception', $exception);
        } else {
            $this->assertInstanceOf('PHPUnit_Framework_Exception', $exception);
        }
    }

    /**
     * @covers ::expectExceptionCode
     * @covers ::tearDown
     */
    public function testParentExpectExceptionCode()
    {
        if (!parent::isParentMethod('expectExceptionCode')) {
            $this->markTestSkipped('PHPUnit\Framework\TestCase::expectExceptionCode() does not exist.');
            return;
        }

        $this->isParentMethodOverriden = ['expectExceptionCode' => true];
        $this->expectException('RuntimeException');
        $this->expectExceptionCode(41);
        throw new \RuntimeException('', 41);
    }

    public function objectProvider()
    {
        return [
            'static' => ['SergeyMakinen\Tests\Stubs\Class2', 'Static'],
            'instance' => [new Class2(), ''],
        ];
    }

    /**
     * @covers ::getProperty
     * @covers ::getInaccessibleProperty
     * @covers ::setInaccessibleProperty
     * @covers ::invokeInaccessibleMethod
     * @dataProvider objectProvider
     *
     * @param object|string $object
     * @param string $nameSuffix
     */
    public function testGetSetInvoke($object, $nameSuffix)
    {
        $this->assertSame('private1', $this->getInaccessibleProperty($object, '_private1' . $nameSuffix));
        $this->assertSame('private2', $this->getInaccessibleProperty($object, '_private2' . $nameSuffix));
        $this->assertSame('protected2', $this->getInaccessibleProperty($object, '_protected' . $nameSuffix));

        $this->setInaccessibleProperty($object, '_private1' . $nameSuffix, '_private1');
        $this->setInaccessibleProperty($object, '_private2' . $nameSuffix, '_private2');
        $this->setInaccessibleProperty($object, '_protected' . $nameSuffix, '_protected2');

        $this->assertSame('_private1', $this->getInaccessibleProperty($object, '_private1' . $nameSuffix));
        $this->assertSame('_private2', $this->getInaccessibleProperty($object, '_private2' . $nameSuffix));
        $this->assertSame('_protected2', $this->getInaccessibleProperty($object, '_protected' . $nameSuffix));

        $this->assertSame('private1', $this->invokeInaccessibleMethod($object, '_private1' . $nameSuffix));
        $this->assertSame('private2', $this->invokeInaccessibleMethod($object, '_private2' . $nameSuffix));
        $this->assertSame('protected2', $this->invokeInaccessibleMethod($object, '_protected' . $nameSuffix));
    }

    protected function executeOverriddenAndParentMethod($name, \Closure $closure)
    {
        $this->isParentMethodOverriden = [$name => false];
        $closure();
        $this->isParentMethodOverriden = [];

        if (!parent::isParentMethod($name)) {
            $this->markTestIncomplete('PHPUnit\Framework\TestCase::' . $name . '() does not exist.');
            return;
        }

        $this->isParentMethodOverriden = [$name => true];
        $closure();
        $this->isParentMethodOverriden = [];
    }

    /**
     * @inheritDoc
     */
    protected function isParentMethod($name)
    {
        if (!isset($this->isParentMethodOverriden[$name])) {
            return parent::isParentMethod($name);
        } else {
            $value = $this->isParentMethodOverriden[$name];
            unset($this->isParentMethodOverriden[$name]);
            return $value;
        }
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->isParentMethodOverriden = [];
    }
}
