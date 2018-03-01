<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

class FlattenPathTest extends \PHPUnit\Framework\TestCase
{
    public function testSingleNode(): void
    {
        self::assertEquals('file', \Keboola\Processor\FlattenFolders\flattenPath(['file']));
    }

    public function testMultiNode(): void
    {
        self::assertEquals('folder-file', \Keboola\Processor\FlattenFolders\flattenPath(['folder', 'file']));
    }

    public function testReplaceDash(): void
    {
        self::assertEquals('file--file', \Keboola\Processor\FlattenFolders\flattenPath(['file-file']));
    }
}
