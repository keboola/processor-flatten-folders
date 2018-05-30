<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\FlattenStrategy\ConcatStrategy;
use PHPUnit\Framework\TestCase;

class FlattenStrategyConcatTest extends TestCase
{
    public function testSingleNode(): void
    {
        self::assertEquals('file', (new ConcatStrategy())->flattenPath(['file']));
    }

    public function testMultiNode(): void
    {
        self::assertEquals('folder-file', (new ConcatStrategy())->flattenPath(['folder', 'file']));
    }

    public function testReplaceDash(): void
    {
        self::assertEquals('file--file', (new ConcatStrategy())->flattenPath(['file-file']));
    }
}
