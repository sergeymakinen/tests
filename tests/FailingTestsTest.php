<?php

namespace SergeyMakinen\Tests;

class FailingTestsTest extends TestCase
{
    public function testExpectException()
    {
        $this->expectException('LogicException');
        throw new \RuntimeException();
    }

    public function testExpectExceptionCode()
    {
        $this->expectExceptionCode(42);
        throw new \RuntimeException('', 41);
    }

    public function testExpectExceptionMessage()
    {
        $this->expectExceptionMessage('foo');
        throw new \RuntimeException('bar');
    }

    public function testExpectExceptionMessageRegExp()
    {
        $this->expectExceptionMessageRegExp('/^\d+$/');
        throw new \RuntimeException('abc');
    }
}
