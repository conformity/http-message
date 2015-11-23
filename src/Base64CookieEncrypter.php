<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 23/11/15
 * Time: 18:54
 */

namespace Conformity\Http\Message;


class Base64CookieEncrypter implements CookieEncrypterInterface
{
    public function encrypt($value)
    {
        return base64_encode($value);
    }

    public function decrypt($value)
    {
        return base64_decode($value);
    }

}