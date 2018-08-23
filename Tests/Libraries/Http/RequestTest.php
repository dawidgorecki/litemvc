<?php

namespace Libraries\Core;

use Libraries\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testGet()
    {
        $_GET['name'] = 'Chris';
        $this->assertEquals('Chris', Request::get('name'));
    }

    public function testPost()
    {
        $_POST['cost'] = 15.7;
        $this->assertEquals(15.7, Request::post('cost'));
    }

    public function testCookie()
    {
        $_COOKIE['color'] = '#ff25bb';
        $this->assertEquals('#ff25bb', Request::cookie('color'));
    }

    public function testGetWithNonExistingKey()
    {
        $this->assertEquals('', Request::get('wrong_key_get'));
    }

    public function testPostWithNonExistingKey()
    {
        $this->assertEquals('', Request::post('wrong_key_post'));
    }

    public function testCookieWithNonExistingKey()
    {
        $this->assertEquals('', Request::cookie('wrong_key_cookie'));
    }

    public function testGetWithNonExistingKeyAndDefault()
    {
        $this->assertEquals('f3b1c2a8d7', Request::get('token',false,'f3b1c2a8d7'));
    }

    public function testPostWithNonExistingKeyAndDefault()
    {
        $this->assertEquals(20, Request::post('age',false,20));
    }

    public function testCookieWithNonExistingKeyAndDefault()
    {
        $this->assertEquals('monster', Request::cookie('id',false,'monster'));
    }

    public function testPostXssFilter()
    {
        $_POST['tag_post'] = '<a href="#">About</a>';
        $_POST['script_post'] = '<script>alert("hello!");</script>';

        $this->assertEquals('<a href="#">About</a>', Request::post('tag_post', false));
        $this->assertEquals('About', Request::post('tag_post', true));
        $this->assertEquals('alert(&quot;hello!&quot;);', Request::post('script_post', true));
    }

    public function testGetXssFilter()
    {
        $_GET['tag_get'] = '<a href="#">Home</a>';
        $_GET['script_get'] = '<script>alert("You win!");</script>';

        $this->assertEquals('<a href="#">Home</a>', Request::get('tag_get', false));
        $this->assertEquals('Home', Request::get('tag_get', true));
        $this->assertEquals('alert(&quot;You win!&quot;);', Request::get('script_get', true));
    }

    public function testCookieXssFilter()
    {
        $_COOKIE['tag_cookie'] = '<a href="#">Docs</a>';
        $_COOKIE['script_cookie'] = '<script>alert("Error");</script>';

        $this->assertEquals('<a href="#">Docs</a>', Request::cookie('tag_cookie', false));
        $this->assertEquals('Docs', Request::cookie('tag_cookie', true));
        $this->assertEquals('alert(&quot;Error&quot;);', Request::cookie('script_cookie', true));
    }

}
