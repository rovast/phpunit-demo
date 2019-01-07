<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

use PHPUnit\DbUnit\DataSet\ArrayDataSet;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

/**
 * 测试之前，需要在 MySQL 中新建数据库 phpunit，并且新建表 guestbook
 * CREATE TABLE `guestbook` (
 * `id` bigint(20) NOT NULL,
 * `content` varchar(255) COLLATE utf8mb4_bin NOT NULL,
 * `user` varchar(255) COLLATE utf8mb4_bin NOT NULL,
 * `created` datetime NOT NULL
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
 * Class ConnectionTest.
 */
class ConnectionTest extends TestCase
{
    use TestCaseTrait;

    /**
     * @return \PHPUnit\DbUnit\Database\DefaultConnection
     */
    public function getConnection()
    {
        $pdo = new \PDO(
            'mysql:host=127.0.0.1:33060;dbname=phpunit;charset=utf8mb4',
            'root',
            '112233'
        );

        return $this->createDefaultDBConnection($pdo);
    }

    /**
     * @return ArrayDataSet
     */
    public function getDataSet()
    {
        return new ArrayDataSet(
            [
                'guestbook' => [
                    [
                        'id' => 1,
                        'content' => 'Hello buddy!',
                        'user' => 'joe',
                        'created' => '2010-04-24 17:15:23',
                    ],
                    [
                        'id' => 2,
                        'content' => 'I like it!',
                        'user' => 'mike',
                        'created' => '2010-04-26 12:14:20',
                    ],
                ],
            ]
        );
    }

    public function testCreateDataSet()
    {
        $this->markTestSkipped('just an example, skipped');
        $tableNames = ['guestbook'];
        $dataSet = $this->getConnection()->createDataSet();
    }

    public function testCreateQueryTable()
    {
        $this->markTestSkipped('just an example, skipped');
        $tableNames = ['guestbook'];
        $queryTable = $this->getConnection()->createQueryTable('guestbook', 'SELECT * FROM guestbook');
    }

    public function testGetRowCount()
    {
        $this->assertSame(2, $this->getConnection()->getRowCount('guestbook'));
    }

    /**
     * 测试表的内容和给定的数据集相等.
     */
    public function testAddEntry()
    {
        $queryTable = $this->getConnection()->createQueryTable(
            'guestbook', 'SELECT * FROM guestbook'
        );
        $expectedTable = $this->createFlatXmlDataSet('expectedBook.xml')
            ->getTable('guestbook');
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
