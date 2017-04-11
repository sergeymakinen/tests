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

abstract class TestCaseVersion6 extends \PHPUnit\Framework\TestCase
{
    use ExpectExceptionTrait;
    use ExtensionTrait;
}
