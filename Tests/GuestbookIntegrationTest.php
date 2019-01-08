<?php

/*
 * This file is part of the rovast/phpunit-demo.
 * (c) rovast <rovast@163.com>
 * This source file is subject to the MIT license that is bundled.
 */

namespace Rovast\PhpunitDemo\Tests;

use PHPUnit\Framework\TestCase;

class GuestbookIntegrationTest extends TestCase
{
    /**
     * A test that specifies that no method should be covered.
     *
     * @coversNothing
     */
    public function testAddEntry()
    {
        $guestbook = new Guestbook();
        $guestbook->addEntry('suzy', 'Hello world!');

        $queryTable = $this->getConnection()->createQueryTable(
            'guestbook', 'SELECT * FROM guestbook'
        );

        $expectedTable = $this->createFlatXmlDataSet('expectedBook.xml')
            ->getTable('guestbook');

        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
