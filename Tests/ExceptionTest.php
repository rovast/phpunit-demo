<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

use PHPUnit\Framework\TestCase;

class ExceptionTest extends TestCase
{
    public function testException()
    {
        $this->expectException(\Exception::class);

        throw new \Exception('test');
    }

    /**
     * @throws \Exception
     * @test
     * @expectedException \Exception
     */
    public function exceptionExpect()
    {
        throw new \Exception('test');
    }
}
