<?php

namespace Conformity\Http\Message\Test;

use PHPUnit_Framework_TestCase as TestCase;
use Conformity\Http\Message\RelativeStream;
use Conformity\Http\Message\Stream;

/**
 * @covers \Zend\Diactoros\RelativeStream
 */
class RelativeStreamTest extends TestCase
{
    public function testToString()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->seek(100, SEEK_SET)->shouldBeCalled();
        $decorated->getContents()->shouldBeCalled()->willReturn('foobarbaz');

        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->__toString();
        $this->assertEquals('foobarbaz', $ret);
    }

    public function testClose()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->close()->shouldBeCalled();
        $stream = new RelativeStream($decorated->reveal(), 100);
        $stream->close();
    }

    public function testDetach()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->detach()->shouldBeCalled()->willReturn(250);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->detach();
        $this->assertEquals(250, $ret);
    }

    public function testGetSize()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->getSize()->shouldBeCalled()->willReturn(250);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->getSize();
        $this->assertEquals(150, $ret);
    }

    public function testTell()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->tell()->shouldBeCalled()->willReturn(188);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->tell();
        $this->assertEquals(88, $ret);
    }

    public function testIsSeekable()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->isSeekable()->shouldBeCalled()->willReturn(true);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->isSeekable();
        $this->assertEquals(true, $ret);
    }

    public function testIsWritable()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->isWritable()->shouldBeCalled()->willReturn(true);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->isWritable();
        $this->assertEquals(true, $ret);
    }

    public function testIsReadable()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->isReadable()->shouldBeCalled()->willReturn(false);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->isReadable();
        $this->assertEquals(false, $ret);
    }

    public function testSeek()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->seek(126, SEEK_SET)->shouldBeCalled()->willReturn(0);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->seek(26);
        $this->assertEquals(0, $ret);
    }

    public function testRewind()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->seek(100, SEEK_SET)->shouldBeCalled()->willReturn(0);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->rewind();
        $this->assertEquals(0, $ret);
    }

    public function testWrite()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->write("foobaz")->shouldBeCalled()->willReturn(6);
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->write("foobaz");
        $this->assertEquals(6, $ret);
    }

    public function testRead()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->read(3)->shouldBeCalled()->willReturn("foo");
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->read(3);
        $this->assertEquals("foo", $ret);
    }

    public function testGetContents()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->getContents()->shouldBeCalled()->willReturn("foo");
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->getContents();
        $this->assertEquals("foo", $ret);
    }

    public function testGetMetadata()
    {
        $decorated = $this->prophesize('Conformity\Http\Message\Stream');
        $decorated->getMetadata("bar")->shouldBeCalled()->willReturn("foo");
        $stream = new RelativeStream($decorated->reveal(), 100);
        $ret = $stream->getMetadata("bar");
        $this->assertEquals("foo", $ret);
    }
}
