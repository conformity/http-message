<?php

namespace Conformity\Http\Message\Exception;

use BadMethodCallException;

/**
 * Exception indicating a deprecated method.
 */
class DeprecatedMethodException extends BadMethodCallException implements ExceptionInterface
{
}
