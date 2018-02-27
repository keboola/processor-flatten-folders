<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

/**
 * Class FlattenFilenameTest
 */
class FlattenFilenameTest extends \PHPUnit\Framework\TestCase
{
    public function testSingleNode(): void
    {
        self::assertEquals('file', \Keboola\Processor\FlattenFolders\flattenFilename(['file']));
    }

    public function testMultiNode(): void
    {
        self::assertEquals('folder-file', \Keboola\Processor\FlattenFolders\flattenFilename(['folder', 'file']));
    }

    public function testReplaceDash(): void
    {
        self::assertEquals('file--file', \Keboola\Processor\FlattenFolders\flattenFilename(['file-file']));
    }
}
