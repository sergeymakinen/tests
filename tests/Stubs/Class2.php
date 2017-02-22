<?php

namespace SergeyMakinen\Tests\Stubs;

class Class2 extends Class1
{
    private $_private2 = 'private2';

    private static $_private2Static = 'private2';

    protected $_protected = 'protected2';

    protected static $_protectedStatic = 'protected2';

    private function _private2()
    {
        return 'private2';
    }

    private static function _private2Static()
    {
        return 'private2';
    }

    protected function _protected()
    {
        return 'protected2';
    }

    protected static function _protectedStatic()
    {
        return 'protected2';
    }
}
