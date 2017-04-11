<?php
/**
 * Common tests stuff
 *
 * @see       https://github.com/sergeymakinen/tests
 * @copyright Copyright (c) 2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/tests/blob/master/LICENSE MIT License
 */

namespace SergeyMakinen\Tests\Util;

trait ExpectExceptionTrait
{
    /**
     * @param string $exception
     * @throws \Exception
     */
    public function expectException($exception)
    {
        if (!is_string($exception)) {
            /** @var \PHPUnit_Util_InvalidArgumentHelper|\PHPUnit\Util\InvalidArgumentHelper $class */
            $class = $this->getInvalidArgumentHelperClass();
            throw $class::factory(1, 'string');
        }

        $this->setInaccessibleProperty($this, 'expectedException', $exception);
    }

    /**
     * @param int|string $code
     * @throws \Exception
     */
    public function expectExceptionCode($code)
    {
        if (!$this->getInaccessibleProperty($this, 'expectedException')) {
            $this->setInaccessibleProperty($this, 'expectedException', 'Exception');
        }
        if (!is_int($code) && !is_string($code)) {
            /** @var \PHPUnit_Util_InvalidArgumentHelper|\PHPUnit\Util\InvalidArgumentHelper $class */
            $class = $this->getInvalidArgumentHelperClass();
            throw $class::factory(1, 'integer or string');
        }

        $this->setInaccessibleProperty($this, 'expectedExceptionCode', $code);
    }

    /**
     * @param string $message
     * @throws \Exception
     */
    public function expectExceptionMessage($message)
    {
        if (!$this->getInaccessibleProperty($this, 'expectedException')) {
            $this->setInaccessibleProperty($this, 'expectedException', 'Exception');
        }
        if (!is_string($message)) {
            /** @var \PHPUnit_Util_InvalidArgumentHelper|\PHPUnit\Util\InvalidArgumentHelper $class */
            $class = $this->getInvalidArgumentHelperClass();
            throw $class::factory(1, 'string');
        }

        $this->setInaccessibleProperty($this, 'expectedExceptionMessage', $message);
    }

    /**
     * @param string $messageRegExp
     * @throws \Exception
     */
    public function expectExceptionMessageRegExp($messageRegExp)
    {
        if (!$this->getInaccessibleProperty($this, 'expectedException')) {
            $this->setInaccessibleProperty($this, 'expectedException', 'Exception');
        }
        if (!is_string($messageRegExp)) {
            /** @var \PHPUnit_Util_InvalidArgumentHelper|\PHPUnit\Util\InvalidArgumentHelper $class */
            $class = $this->getInvalidArgumentHelperClass();
            throw $class::factory(1, 'string');
        }

        $this->setInaccessibleProperty($this, 'expectedExceptionMessageRegExp', $messageRegExp);
    }

    /**
     * @return string
     */
    private function getInvalidArgumentHelperClass()
    {
        return class_exists('PHPUnit_Util_InvalidArgumentHelper') ? 'PHPUnit_Util_InvalidArgumentHelper' : 'PHPUnit\Util\InvalidArgumentHelper';
    }
}
