<?php

namespace SergeyMakinen\Tests;

use SebastianBergmann\Comparator\DOMNodeComparator;
use SergeyMakinen\Tests\Stubs\Class2;

/**
 * @coversDefaultClass \SergeyMakinen\Tests\TestCase
 * @covers ::<private>
 */
class TestCaseTest extends TestCase
{
    /**
     * @covers ::expectException
     */
    public function testExpectException()
    {
        $this->expectException('RuntimeException');
        throw new \RuntimeException();
    }

    /**
     * @covers ::expectException
     */
    public function testExpectExceptionWithInvalidData()
    {
        $exception = null;
        try {
            $this->expectException([]);
        } catch (\Exception $e) {
            $exception = $e;
        } catch (\TypeError $e) {
            $exception = $e;
        }
        $this->assertInstanceOfFrameworkException($exception);
    }

    /**
     * @covers ::expectExceptionCode
     */
    public function testExpectExceptionCode()
    {
        $this->expectExceptionCode(42);
        throw new \RuntimeException('', 42);
    }

    /**
     * @covers ::expectExceptionCode
     */
    public function testExpectExceptionCodeWithInvalidData()
    {
        $exception = null;
        try {
            $this->expectExceptionCode([]);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertInstanceOfFrameworkException($exception);
    }

    /**
     * @covers ::expectExceptionMessage
     */
    public function testExpectExceptionMessage()
    {
        $this->expectExceptionMessage('foo');
        throw new \RuntimeException('foo');
    }

    /**
     * @covers ::expectExceptionMessage
     */
    public function testExpectExceptionMessageWithInvalidData()
    {
        $exception = null;
        try {
            $this->expectExceptionMessage([]);
        } catch (\Exception $e) {
            $exception = $e;
        } catch (\TypeError $e) {
            $exception = $e;
        }
        $this->assertInstanceOfFrameworkException($exception);
    }

    /**
     * @covers ::expectExceptionMessageRegExp
     */
    public function testExpectExceptionMessageRegExp()
    {
        $this->expectExceptionMessageRegExp('/^\d+$/');
        throw new \RuntimeException('41');
    }

    /**
     * @covers ::expectExceptionMessageRegExp
     */
    public function testExpectExceptionMessageRegExpWithInvalidData()
    {
        $exception = null;
        try {
            $this->expectExceptionMessageRegExp([]);
        } catch (\Exception $e) {
            $exception = $e;
        } catch (\TypeError $e) {
            $exception = $e;
        }
        $this->assertInstanceOfFrameworkException($exception);
    }

    /**
     * @covers ::createMock
     */
    public function testCreateMock()
    {
        $mock = $this->createMock('SergeyMakinen\Tests\Stubs\Class1');
        $mock
            ->method('foobar')
            ->willReturnArgument(0);
        $this->assertSame('baz', $mock->foobar('baz'));
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

    public function testDomNodeComparator()
    {
        $comparator = new DOMNodeComparator();
        $this->assertTrue(true);
    }

    public function testFailingTests()
    {
        $class = class_exists('PHPUnit_Framework_TestSuite') ? 'PHPUnit_Framework_TestSuite' : 'PHPUnit\Framework\TestSuite';
        /** @var \PHPUnit_Framework_TestSuite|\PHPUnit\Framework\TestSuite $suite */
        $suite = new $class();
        $suite->addTestFile(__DIR__ . '/FailingTestsTest.php');
        $result = $suite->run();
        $this->assertSame($result->count(), $result->failureCount());
    }

    protected function assertInstanceOfFrameworkException($actual)
    {
        if (
            class_exists('PHPUnit\Runner\Version')
            && version_compare(\PHPUnit\Runner\Version::id(), '7.0', '>=')
            && $actual instanceof \TypeError
        ) {
            $this->markTestSkipped('This test is irrelevant on PHPUnit 7.0 or higher');
        }

        $class = class_exists('PHPUnit_Framework_Exception') ? 'PHPUnit_Framework_Exception' : 'PHPUnit\Framework\Exception';
        $this->assertInstanceOf($class, $actual);
        $this->setInaccessibleProperty($this, 'expectedException', null);
    }
}
