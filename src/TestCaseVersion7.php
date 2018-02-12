<?php
/**
 * Common tests stuff
 *
 * @see       https://github.com/sergeymakinen/tests
 * @copyright Copyright (c) 2017-2018 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/tests/blob/master/LICENSE MIT License
 */

namespace SergeyMakinen\Tests;

use SergeyMakinen\Tests\Util\ExtensionTrait;

abstract class TestCaseVersion7 extends \PHPUnit\Framework\TestCase
{
    use ExtensionTrait;

    /**
     * @param int|string $code
     * @throws \Exception
     */
    public function expectExceptionCode($code): void
    {
        if (!is_int($code) && !is_string($code)) {
            throw \PHPUnit\Util\InvalidArgumentHelper::factory(1, 'integer or string');
        }

        parent::expectExceptionCode($code);
    }
}
