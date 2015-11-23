# http-message

A PSR7 Compliant http-message implementation.

This package provides a simple implementation of the PSR7 specification.

It is at its core a fork of the most feature rich psr7 implementation zend/diactoros.

However we found package a little bloated with no support for cookies (admittedley not within the scope of the psr).

We also feel the included server while functional isn't needed for a full decoupled implementation.

So we took the existing well tested codebase, added response cookie support, added a way to encrypt/decrypt cookies via a middleware and removed the server and emitters.

Everything else still exists in its current form with the namespaces changed to ```Conformity\Http\Message```

Included in the base Response class is the new ```Conformity\Http\Message\Response\Cookie\CookieTrait``` which uses the new ```Conformity\Http\Message\Response\Cookie\Cookie``` class.

The cookie trait provides an immutable interface inline with the PSR7 spec for headers

```php
<?php

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
     * @param mixed $name string or Cookie instance
     * @param null $value
     * @param null $expires
     * @param null $path
     * @param null $domain
     * @param bool|false $secure
     * @param bool|false $httpOnly
     *
     * @return Response new instance
     */
    public function withCookie($cookie, $value = '', $expires = null, $path = '/', $domain = null, $secure = false, $httpOnly = true);

    /**
     * Delete a cookie on the clients browser by settings the expires for the cookie in the past.
     *
     * @param $name
     * @return Response new instance
     */
    public function withoutCookie($name);

    /**
     * Check if the response has the cookie by name
     *
     * @param $name
     * @return bool
     */
    public function hasCookie($name);

    /**
     * get the cookie to modify and return
     *
     * @param $name
     * @return mixed null or Cookie instance
     */
    public function getCookie($name);

    /**
     * Return all cookies on the response
     *
     * @return array
     */
    public function getCookies();

}
```

This trait, can also be used on any PSR7 compliant response.

We have also included a simple middleware which can decrypt request cookie, and encrypt response cookies.

This is done by creating an instance of the middleware with 2 arguments:

````$middleware = new \Conformity\Http\Message\Middleware\EncryptCookies(Conformity\Http\Message\CookieEncrypterInterface $encrypter, $except = ['names', 'of', 'cookies', 'to', 'ignore']);```

The CookieEncrypterInterface has two simple methods: ```encrypt($value);``` ```decrypt($value);```.

Simply create a class which implements this interface and you can pass that as the first argument to the middleware.

There is an included ```Base64CookieEncoder``` implementation, but this is meant more as an example and for tests, rather than a production ready encrypter (base64_encode isnt safe enough).

Once created just pass your middleware instance to your middleware runner and it will start protecting your cookies (apart from the cookies supplied in the second middleware constructor argument).
