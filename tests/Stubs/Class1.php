<?php

namespace SergeyMakinen\Tests\Stubs;

class Class1
{
    private $_private1 = 'private1';

    private static $_private1Static = 'private1';

    protected $_protected = 'protected1';

    protected static $_protectedStatic = 'protected1';

    private function _private1()
    {
        return 'private1';
    }

    private static function _private1Static()
    {
        return 'private1';
    }

    protected function _protected()
    {
        return 'protected1';
    }

    protected static function _protectedStatic()
    {
        return 'protected1';
    }
}
