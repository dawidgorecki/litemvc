<?php

namespace Libraries\Http;

use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{

    public function testSet()
    {
        Session::set('user', 'Mark');
        $this->assertEquals('Mark', $_SESSION['user']);
    }

    public function testAdd()
    {
        Session::add('countries', 'Poland');
        Session::add('countries', 'Italy');

        $this->assertTrue(is_array($_SESSION['countries']));
        $this->assertEquals('Poland', $_SESSION['countries'][0]);
        $this->assertEquals('Italy', $_SESSION['countries'][1]);
    }

    public function testGet()
    {
        $_SESSION['name'] = 'John';
        $this->assertEquals('John', Session::get('name'));
    }

    public function testGetWithNonExistingKey()
    {
        $this->assertEquals('', Session::get('hash'));
    }

    public function testGetWithNonExistingKeyAndDefault()
    {
        $this->assertEquals(15, Session::get('age', false, 15));
    }

    public function testGetXssFilter()
    {
        $_SESSION['tag_session'] = '<a href="#">Download</a>';
        $_SESSION['script_session'] = '<script>alert("You lose!");</script>';

        $this->assertEquals('<a href="#">Download</a>', Session::get('tag_session', false));
        $this->assertEquals('Download', Session::get('tag_session', true));
        $this->assertEquals('alert(&quot;You lose!&quot;);', Session::get('script_session', true));
    }

    public function testDelete()
    {
        $_SESSION['first_name'] = 'John';
        $_SESSION['last_name'] = 'Doe';

        $_SESSION['cities'] = [
            'Kalisz',
            'New York'
        ];

        Session::delete('first_name');

        $this->assertFalse(isset($_SESSION['first_name']));
        $this->assertTrue(isset($_SESSION['last_name']));
        $this->assertTrue(isset($_SESSION['cities']));

        Session::delete(['last_name', 'cities']);

        $this->assertFalse(isset($_SESSION['last_name']));
        $this->assertFalse(isset($_SESSION['cities']));
    }

    public function testUserIsLoggedIn()
    {
        $this->assertFalse(Session::userIsLoggedIn());

        $_SESSION['user_logged_in'] = 1;
        $this->assertTrue(Session::userIsLoggedIn());
    }
    
}
