<?php

namespace Conformity\Http\Message\Test\Middleware;

use Conformity\Http\Message\Base64CookieEncrypter;
use Conformity\Http\Message\Middleware\EncryptCookies;
use Conformity\Http\Message\Response;
use Conformity\Http\Message\ServerRequestFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EncryptCookiesTest extends TestCase
{
    public function testCookiesGetEncrytedDecrypted()
    {
        $request = ServerRequestFactory::fromGlobals(null, null, null, [
            'cookie1' => 'a value NOT to be encrypted',
            'cookie2' => base64_encode('a value that IS encrypted')
        ]);

        $response = new Response();

        $middleware = new EncryptCookies(new Base64CookieEncrypter(), [
            'cookie1',
            'cookie3'
        ]);

        $response = $middleware($request, $response, function(RequestInterface $request, ResponseInterface $response){

            //simply add existing cookies to the response, and add a new one so we can check the encoded cookie is decrypted in the callback
            foreach($request->getCookieParams() as $key => $value){
                $response = $response->withCookie($key, $value);

                if($key == 'cookie2'){
                    $response = $response->withCookie('cookie3', $value);
                }
            }

            return $response;
        });

        $cookie1 = $response->getCookie('cookie1');
        $cookie2 = $response->getCookie('cookie2');
        $cookie3 = $response->getCookie('cookie3');

        $this->assertEquals('a value NOT to be encrypted', $cookie1->getValue());

        $this->assertEquals(base64_encode('a value that IS encrypted'), $cookie2->getValue());

        $this->assertEquals('a value that IS encrypted', $cookie3->getValue());
    }

}
