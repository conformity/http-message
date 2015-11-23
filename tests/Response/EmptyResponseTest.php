<?php

namespace Conformity\Http\Message\Test\Response;

use PHPUnit_Framework_TestCase as TestCase;
use Conformity\Http\Message\Response\EmptyResponse;

class EmptyResponseTest extends TestCase
{
    public function testConstructor()
    {
        $response = new EmptyResponse(201);
        $this->assertInstanceOf('Conformity\Http\Message\Response', $response);
        $this->assertEquals('', (string) $response->getBody());
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testHeaderConstructor()
    {
        $response = EmptyResponse::withHeaders(['x-empty' => ['true']]);
        $this->assertInstanceOf('Conformity\Http\Message\Response', $response);
        $this->assertEquals('', (string) $response->getBody());
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('true', $response->getHeaderLine('x-empty'));
    }
}
