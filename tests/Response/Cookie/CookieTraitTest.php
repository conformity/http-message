<?php

namespace Conformity\Http\Message\Test\Response\Cookie;

use Conformity\Http\Message\Response\Cookie\Cookie;
use PHPUnit_Framework_TestCase as TestCase;
use Conformity\Http\Message\Response;

class CookieTraitTest extends TestCase
{
    public function testAddCookieAddsToHeader()
    {
        $response = (new Response())
            ->withCookie('cookie_name', 'cookie value');

        $this->assertEquals(
            "cookie_name=cookie+value; path=/; httponly",
            $response->getHeaderLine('Set-Cookie')
        );
    }

    public function testAddCookieInstanceAddsToHeader()
    {
        $response = (new Response())
            ->withCookie(new Cookie('cookie_name', 'cookie value'));

        $this->assertEquals(
            "cookie_name=cookie+value; path=/; httponly",
            $response->getHeaderLine('Set-Cookie')
        );
    }

    public function testAddCookieAddsCookieInstance()
    {
        $response = (new Response())
            ->withCookie('cookie_name', 'cookie_value');

        $this->assertInstanceOf(Cookie::class, $response->getCookie('cookie_name'));
    }

    public function testHasCookie()
    {
        $response = (new Response());

        $this->assertFalse($response->hasCookie('test_cookie'));

        $response = $response->withCookie('test_cookie');

        $this->assertTrue($response->hasCookie('test_cookie'));
    }

    public function testGetCookie()
    {
        $response = (new Response());

        $this->assertNull($response->getCookie('test_cookie'));

        $response = $response->withCookie('test_cookie');

        $this->assertInstanceOf(Cookie::class, $response->getCookie('test_cookie'));
    }

    public function testWithoutCookie()
    {
        //set to prevent warnings
        date_default_timezone_set('UTC');

        $response = (new Response());

        $response = $response->withoutCookie('test_cookie');

        $this->assertInstanceOf(Cookie::class, $response->getCookie('test_cookie'));

        $cookie = $response->getCookie('test_cookie');

        $this->assertTrue($cookie->isDelete());
    }

    public function testGetCookies()
    {
        $response = (new Response());

        $this->assertEquals(0, count($response->getCookies()));

        $response = $response->withCookie('test_cookie');

        $this->assertEquals(1, count($response->getCookies()));
    }
}
