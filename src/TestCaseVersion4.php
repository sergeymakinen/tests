<?php
/**
 * Common tests stuff
 *
 * @see       https://github.com/sergeymakinen/tests
 * @copyright Copyright (c) 2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/tests/blob/master/LICENSE MIT License
 */

namespace SergeyMakinen\Tests;

use SergeyMakinen\Tests\Util\ExpectExceptionTrait;
use SergeyMakinen\Tests\Util\ExtensionTrait;

abstract class TestCaseVersion4 extends \PHPUnit_Framework_TestCase
{
    use ExpectExceptionTrait;
    use ExtensionTrait;

    /**
     * @param string $originalClassName
     * @return \PHPUnit_Framework_MockObject_MockObject
     * @throws \Exception
     */
    protected function createMock($originalClassName)
    {
        return $this->getMockBuilder($originalClassName)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->getMock();
    }
}
