<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\FlattenStrategy\ConcatStrategy;
use Keboola\Processor\FlattenFolders\FlattenStrategy\HashStrategy;
use PHPUnit\Framework\TestCase;

class FlattenStrategyHashTest extends TestCase
{

    /**
     * @dataProvider flattenProvider
     * @param array $path
     * @param string $expected
     */
    public function testFlatten(array $path, string $expected): void
    {
        $hash = new HashStrategy();
        $this->assertEquals($expected, $hash->flattenPath($path));
    }

    public function flattenProvider(): array
    {
        return [
            [
                ['folder', 'file'],
                '6f619f3079c75f39cd062abb41dcd2d05c152361',
            ],
            [
                ['file', 'folder'],
                'ebf381c25fa942f2e0e6dc63deb3ea54a6cef664',
            ],
            [
                ['file-file'],
                'a34983024fd243834e9bb29e59ff73ae507bc4d4',
            ],
        ];
    }
}
