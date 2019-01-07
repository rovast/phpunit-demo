<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

class StackTest extends \PHPUnit\Framework\TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        array_push($stack, 'foo');
        $this->assertSame(1, count($stack));
        $this->assertSame('foo', $stack[count($stack) - 1]);

        $this->assertSame('foo', array_pop($stack));
        $this->assertSame(0, count($stack));
    }

    public function testEmpty()
    {
        $stack = [];
        $this->assertSame(0, count($stack));

        return $stack;
    }

    /**
     * @depends testEmpty
     *
     * @param array $stack
     *
     * @return array
     */
    public function testPush(array $stack)
    {
        array_push($stack, 'foo');
        $this->assertSame('foo', $stack[count($stack) - 1]);
        $this->assertNotEmpty($stack);

        return $stack;
    }

    /**
     * @depends testPush
     *
     * @param array $stack
     */
    public function testPop(array $stack)
    {
        $this->assertSame('foo', array_pop($stack));
        $this->assertEmpty($stack);
    }
}
