<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class DatabaseTestWithAnnotation
 * @package Rovast\PhpunitDemo\Tests
 * @requires extension mysqli
 */
class DatabaseTestWithAnnotation extends TestCase
{
    /**
     * @requires PHP 5.3
     */
    public function testConnection()
    {
        // Test requires the mysqli extension and PHP >= 5.3
    }

    // ... All other tests require the mysqli extension
}