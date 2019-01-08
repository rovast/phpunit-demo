<?php
/**
 * Created by PhpStorm.
 * User: rovast
 * Date: 19-1-8
 * Time: 上午11:20
 */

namespace Rovast\PhpunitDemo\Tests;


use PHPUnit\Framework\TestCase;

class ExpectedErrorTest extends TestCase
{
    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude()
    {
        include 'not_existing_file.php';
    }
}