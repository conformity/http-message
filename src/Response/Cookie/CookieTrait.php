<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 23/11/15
 * Time: 17:10
 */

namespace Conformity\Http\Message\Response\Cookie;


trait CookieTrait
{
    /**
     * The cookies added to the response
     * @var array
     */
    protected $cookies = [];

    /**
     * List of cookie names to make lookups faster
     * @var array
     */
    protected $cookieNames = [];

    /**
     * Add a cookie header to the response
     *
     * No need to have more classes for this, simply alter the headers to include the Set-Cookie: header.
     *
     * @param $name
     * @param null $value
     * @param null $expires
     * @param null $path
     * @param null $domain
     * @param bool|false $secure
     * @param bool|false $httpOnly
     *
     * @return Response
     */
    public function withCookie($cookie, $value = '', $expires = null, $path = '/', $domain = null, $secure = false, $httpOnly = true){

        //transform it into a cookie instance
        if(!$cookie instanceof Cookie){
            $cookie = new Cookie($cookie, $value, $expires, $path, $domain, $secure, $httpOnly);
        }

        //save it in the cookies array
        $this->cookies[$cookie->getName()] = $cookie;
        $this->cookieNames[$cookie->getName()] = $cookie->getName();

        //get current cookie headers
        $cookieHeaders = $this->getHeader('Set-Cookie');

        //get a response object without the cookies
        $temp = $this->withoutHeader('Set-Cookie');

        //replace if already set
        $exists = false;
        foreach($cookieHeaders as $index => $cookieString){
            if(substr( $cookieString, 0, (strlen($cookie->getName()) + 1) ) === $cookie->getName() . '='){
                $cookieHeaders[$index] = (string) $cookie;
                $exists = true;
                break;
            }
        }
        //append if not already set
        if(false === $exists){
            $cookieHeaders[] = (string) $cookie;
        }

        $response = $temp->withHeader('Set-Cookie', $cookieHeaders);

        //return new instance
        return $response;
    }

    /**
     * Delete a cookie on the clients browser by settings the expires for the cookie in the past.
     *
     * @param $name
     * @return Response
     */
    public function withoutCookie($name){
        //set cookie with expired time - this way we don't need to parse the headers at all
        return $this->withCookie($name, null, new \DateTime('-1 day'));
    }

    /**
     * Check if the response has the cookie by name
     *
     * @param $name
     * @return bool
     */
    public function hasCookie($name){
        return in_array($name, $this->cookieNames);
    }

    /**
     * get the cookie to modify and return
     *
     * @param $name
     * @return mixed null or Cookie instance
     */
    public function getCookie($name){
        if(!$this->hasCookie($name)){
            return null;
        }
        return $this->cookies[$name];
    }

    /**
     * Return all cookies on the response
     *
     * @return array
     */
    public function getCookies(){
        return $this->cookies;
    }

}