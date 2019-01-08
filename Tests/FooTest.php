<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    /**
     * 断言被调用两次
     */
    public function testFunctionCalledTwoTimesWithSpecificArguments()
    {
        $mock = $this->getMockBuilder(\stdClass::class)
            ->setMethods(['set'])
            ->getMock();

        $mock->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(
                [$this->equalTo('foo'), $this->greaterThan(0)],
                [$this->equalTo('bar'), $this->greaterThan(0)]
            );

        $mock->set('foo', 21);
        $mock->set('bar', 48);
    }

    /**
     *  测试某个方法将会被调用一次，并且以某个特定对象作为参数.
     */
    public function testIdenticalObjectPassed()
    {
        $expectedObject = new \stdClass();

        $mock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['foo'])
            ->getMock();

        $mock->expects($this->once())
            ->method('foo')
            ->with($this->identicalTo($expectedObject));

        $mock->foo($expectedObject);
    }
}
