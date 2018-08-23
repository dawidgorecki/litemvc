<?php

use Libraries\Core\Application;
use Libraries\Utilities\ClassUtils;
use PHPUnit\Framework\TestCase;

class ClassUtilsTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function testGetNamespace()
    {
        $this->assertEquals('Libraries\Core', ClassUtils::getNamespace(Application::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetName()
    {
        $this->assertEquals('Libraries\Core\Application', ClassUtils::getName(Application::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetShortName()
    {
        $this->assertEquals('Application', ClassUtils::getShortName(Application::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetProperties()
    {
        $privateProps = ClassUtils::getProperties(TestCase::class, 'private');
        $this->assertTrue(array_key_exists('name', $privateProps));
        $this->assertFalse(array_key_exists('backupGlobals', $privateProps));

        $protectedProps = ClassUtils::getProperties(TestCase::class, 'protected');
        $this->assertFalse(array_key_exists('name', $protectedProps));
        $this->assertTrue(array_key_exists('backupGlobals', $protectedProps));
    }

}
