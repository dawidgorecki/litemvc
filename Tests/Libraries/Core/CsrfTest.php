<?php

namespace Libraries\Core;

use PHPUnit\Framework\TestCase;

class CsrfTest extends TestCase
{
    public function testTokenLength()
    {
        $token = Csrf::generateToken();
        $this->assertEquals(40, strlen($token));
    }

    public function testIsTokenValid()
    {
        $token = Csrf::generateToken();
        $this->assertFalse(Csrf::isTokenValid());

        $_POST['csrf_token'] = $token;
        $this->assertTrue(Csrf::isTokenValid());

        $_POST['csrf_token'] = '12345';
        $this->assertFalse(Csrf::isTokenValid());
    }
}
