<?php

namespace Libraries\Utilities;

use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{

    public function testSplitByCapitalLetter()
    {
        $stringParts = StringUtils::splitByCapitalLetter('thisIsATest');

        $this->assertEquals('this', $stringParts[0]);
        $this->assertEquals('Is', $stringParts[1]);
        $this->assertEquals('A', $stringParts[2]);
        $this->assertEquals('Test', $stringParts[3]);
    }

    public function testConvertToUnderscored()
    {
        $studlyCaps = 'HelloWorld';
        $camelCase = 'helloWorld';

        $this->assertEquals('hello_world', StringUtils::convertToUnderscored($studlyCaps));
        $this->assertEquals('hello_world', StringUtils::convertToUnderscored($camelCase));
    }

    public function testConvertToStudlyCaps()
    {
        $withHyphens = 'password-reset-hash';
        $withUnderscores = 'password_reset_hash';
        $withCapitals = 'PAssword-reset-HASH';

        $this->assertEquals('PasswordResetHash', StringUtils::convertToStudlyCaps($withHyphens, '-'));
        $this->assertEquals('PasswordResetHash', StringUtils::convertToStudlyCaps($withUnderscores));
        $this->assertEquals('PasswordResetHash', StringUtils::convertToStudlyCaps($withCapitals, '-'));
    }

    public function testConvertToCamelCase()
    {
        $withHyphens = 'hello-world';
        $withUnderscores = 'hello_world';
        $withCapitals = 'HellO_WorlD';

        $this->assertEquals("helloWorld", StringUtils::convertToCamelCase($withHyphens, '-'));
        $this->assertEquals("helloWorld", StringUtils::convertToCamelCase($withUnderscores));
        $this->assertEquals("helloWorld", StringUtils::convertToCamelCase($withCapitals));
    }

}
