<?php

namespace Conformity\Http\Message\Response;

use Conformity\Http\Message\Response;
use Conformity\Http\Message\Stream;

/**
 * A class representing empty HTTP responses.
 */
class EmptyResponse extends Response
{
    /**
     * Create an empty response with the given status code.
     *
     * @param int $status Status code for the response, if any.
     * @param array $headers Headers for the response, if any.
     */
    public function __construct($status = 204, array $headers = [])
    {
        $body = new Stream('php://temp', 'r');
        parent::__construct($body, $status, $headers);
    }

    /**
     * Create an empty response with the given headers.
     *
     * @param array $headers Headers for the response.
     * @return EmptyResponse
     */
    public static function withHeaders(array $headers)
    {
        return new static(204, $headers);
    }
}
