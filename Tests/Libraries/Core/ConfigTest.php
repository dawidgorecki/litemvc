<?php

namespace Libraries\Core;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    public function setUp()
    {
        System::setEnvironment(System::ENV_PRODUCTION);
    }

    public function testGet()
    {
        $this->assertEquals('view', Config::get('DEFAULT_ACTION'));
    }

    public function testGetWithEmptyKey()
    {
        $this->assertEquals('', Config::get(''));
    }

    public function testGetWithNonExistingKey()
    {
        $this->assertEquals('', Config::get('WRONG_KEY'));
    }

    public function testGetWithNonExistingKeyAndDefault()
    {
        $this->assertEquals(123, Config::get('WRONG_KEY', 123));
    }

}
