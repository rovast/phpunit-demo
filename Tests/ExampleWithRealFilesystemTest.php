<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

use PHPUnit\Framework\TestCase;

class ExampleWithRealFilesystemTest extends TestCase
{
    protected function setUp()
    {
        if (file_exists(dirname(__FILE__).'/id')) {
            rmdir(dirname(__FILE__).'/id');
        }
    }

    public function testDirectoryIsCreated()
    {
        $example = new Example('id');
        $this->assertFalse(file_exists(dirname(__FILE__).'/id'));

        $example->setDirectory(dirname(__FILE__));
        $this->assertTrue(file_exists(dirname(__FILE__).'/id'));
    }

    protected function tearDown()
    {
        if (file_exists(dirname(__FILE__).'/id')) {
            rmdir(dirname(__FILE__).'/id');
        }
    }
}

class Example
{
    protected $id;
    protected $directory;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory.DIRECTORY_SEPARATOR.$this->id;

        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0700, true);
        }
    }
}
