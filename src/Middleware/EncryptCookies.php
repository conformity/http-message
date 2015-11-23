<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 23/11/15
 * Time: 18:47
 */

namespace Conformity\Http\Message\Middleware;

use Conformity\Http\Message\CookieEncrypterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EncryptCookies
{
    protected $except = [];

    protected $encrypter = null;

    public function __construct(CookieEncrypterInterface $encrypter, $except = []){
        $this->except = $except;
        $this->encrypter = $encrypter;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next){
        $request = $this->decryptRequestCookies($request);
        $response = $next($request, $response);
        $response = $this->encryptResponseCookies($response);
        return $response;
    }

    private function decryptRequestCookies(ServerRequestInterface $request){
        $cookies = $request->getCookieParams();
        foreach($cookies as $key => $cookie){
            if(!in_array($key, $this->except)){
                $cookies[$key] = $this->encrypter->decrypt($cookie);
            }
        }
        $request = $request->withCookieParams($cookies);
        return $request;
    }

    private function encryptResponseCookies(ResponseInterface $response){
        $cookies = $response->getCookies();

        if(!empty($cookies)){
            foreach($cookies as $cookie){
                if(!in_array($cookie->getName(), $this->except)){
                    $cookie->setValue($this->encrypter->encrypt($cookie->getValue()));
                    $response = $response->withCookie($cookie);
                }
            }
        }

        return $response;
    }

}