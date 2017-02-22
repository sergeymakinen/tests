<?php

namespace SergeyMakinen\Tests;

use SergeyMakinen\Tests\Stubs\Class2;

class TestCaseTest extends TestCase
{
    /**
     * @var array
     */
    protected $isParentMethodOverride = [];

    /**
     * @covers \SergeyMakinen\Tests\TestCase::isParentMethod()
     */
    public function testIsParentMethod()
    {
        $this->assertTrue($this->isParentMethod('getExpectedException'));
        $this->assertFalse($this->isParentMethod(__FUNCTION__));
    }

    /**
     * @covers \SergeyMakinen\Tests\TestCase::createMock()
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
     * @covers \SergeyMakinen\Tests\TestCase::expectException()
     */
    public function testExpectExceptionOverridden()
    {
        $this->isParentMethodOverride = ['expectException' => false];
        $this->expectException('\RuntimeException');
        throw new \RuntimeException();
    }

    /**
     * @covers \SergeyMakinen\Tests\TestCase::expectException()
     */
    public function testExpectExceptionOverriddenError()
    {
        $this->isParentMethodOverride = ['expectException' => false];
        $exception = null;
        try {
            $this->expectException([]);
        } catch (\RuntimeException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\PHPUnit_Framework_Exception', $exception);
    }

    /**
     * @covers \SergeyMakinen\Tests\TestCase::expectException()
     */
    public function testExpectExceptionParent()
    {
        if (!parent::isParentMethod('expectException')) {
            $this->markTestIncomplete('`PHPUnit_Framework_TestCase::expectException` does not exist.');
            return;
        }

        $this->isParentMethodOverride = ['expectException' => true];
        $this->expectException('\RuntimeException');
        throw new \RuntimeException();
    }

    /**
     * @covers \SergeyMakinen\Tests\TestCase::expectExceptionCode()
     * @covers \SergeyMakinen\Tests\TestCase::tearDown()
     */
    public function testExpectExceptionCodeOverridden()
    {
        $this->isParentMethodOverride = [
            'expectException' => false,
            'expectExceptionCode' => false,
        ];
        $this->expectException('\RuntimeException');
        $this->expectExceptionCode(41);
        throw new \RuntimeException('', 41);
    }

    /**
     * @covers \SergeyMakinen\Tests\TestCase::expectExceptionCode()
     * @covers \SergeyMakinen\Tests\TestCase::tearDown()
     */
    public function testExpectExceptionCodeOverriddenError()
    {
        $this->isParentMethodOverride = ['expectExceptionCode' => false];
        $exception = null;
        try {
            $this->expectExceptionCode([]);
        } catch (\RuntimeException $e) {
            $exception = $e;
        }
        $this->assertInstanceOf('\PHPUnit_Framework_Exception', $exception);
    }

    /**
     * @covers \SergeyMakinen\Tests\TestCase::expectExceptionCode()
     * @covers \SergeyMakinen\Tests\TestCase::tearDown()
     */
    public function testExpectExceptionCodeParent()
    {
        if (!parent::isParentMethod('expectExceptionCode')) {
            $this->markTestIncomplete('`PHPUnit_Framework_TestCase::expectExceptionCode` does not exist.');
            return;
        }

        $this->isParentMethodOverride = ['expectExceptionCode' => true];
        $this->expectException('\RuntimeException');
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
     * @covers \SergeyMakinen\Tests\TestCase::getProperty()
     * @covers \SergeyMakinen\Tests\TestCase::getInaccessibleProperty()
     * @covers \SergeyMakinen\Tests\TestCase::setInaccessibleProperty()
     * @covers \SergeyMakinen\Tests\TestCase::invokeInaccessibleMethod()
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
        $this->isParentMethodOverride = [$name => false];
        $closure();
        $this->isParentMethodOverride = [];

        if (!parent::isParentMethod($name)) {
            $this->markTestIncomplete('`PHPUnit_Framework_TestCase::' . $name . '` does not exist.');
            return;
        }

        $this->isParentMethodOverride = [$name => true];
        $closure();
        $this->isParentMethodOverride = [];
    }

    /**
     * @inheritDoc
     */
    protected function isParentMethod($name)
    {
        if (!isset($this->isParentMethodOverride[$name])) {
            return parent::isParentMethod($name);
        } else {
            $value = $this->isParentMethodOverride[$name];
            unset($this->isParentMethodOverride[$name]);
            return $value;
        }
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->isParentMethodOverride = [];
    }
}
