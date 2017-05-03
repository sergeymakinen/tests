<?php
/**
 * Common tests stuff
 *
 * @see       https://github.com/sergeymakinen/tests
 * @copyright Copyright (c) 2017 Sergey Makinen (https://makinen.ru)
 * @license   https://github.com/sergeymakinen/tests/blob/master/LICENSE MIT License
 */

namespace SergeyMakinen\Tests;

// @codeCoverageIgnoreStart
/** @var \PHPUnit_Runner_Version|\PHPUnit\Runner\Version $class */
$class = class_exists('PHPUnit_Runner_Version') ? 'PHPUnit_Runner_Version' : 'PHPUnit\Runner\Version';
$version = $class::id();
if (version_compare($version, '6.0', '>=')) {
    class_alias('SergeyMakinen\Tests\TestCaseVersion6', 'SergeyMakinen\Tests\DynamicTestCase');
} elseif (version_compare($version, '5.0', '>=')) {
    class_alias('SergeyMakinen\Tests\TestCaseVersion5', 'SergeyMakinen\Tests\DynamicTestCase');
} else {
    class_alias('SergeyMakinen\Tests\TestCaseVersion4', 'SergeyMakinen\Tests\DynamicTestCase');
}
// @codeCoverageIgnoreEnd

/**
 * Version independent PHPUnit test case.
 * @mixin \PHPUnit_Framework_TestCase
 * @mixin \PHPUnit\Framework\TestCase
 */
class TestCase extends DynamicTestCase
{
}
