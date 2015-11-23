<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 23/11/15
 * Time: 18:54
 */

namespace Conformity\Http\Message;


interface CookieEncrypterInterface
{

    public function encrypt($value);

    public function decrypt($value);

}