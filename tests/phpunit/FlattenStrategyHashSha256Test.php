<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\FlattenStrategy\ConcatStrategy;
use Keboola\Processor\FlattenFolders\FlattenStrategy\HashSha256Strategy;
use PHPUnit\Framework\TestCase;

class FlattenStrategyHashSha256Test extends TestCase
{

    /**
     * @dataProvider flattenProvider
     * @param array $path
     * @param string $expected
     */
    public function testFlatten(array $path, string $expected): void
    {
        $hash = new HashSha256Strategy();
        self::assertEquals($expected, $hash->flattenPath($path));
    }

    public function flattenProvider(): array
    {
        return [
            [
                ['folder', 'file'],
                '92ad57d53b8e7810ed70d41ef73134a2fcef80fb7cd63afcb08e1a9c364936ca',
            ],
            [
                ['file', 'folder'],
                '512cc4a50e217dbce7491e59c563292c4bf702c07c1f8c4b3d6f213e17737380',
            ],
            [
                ['file-file'],
                'd8740efe800751878558d40eef5000e637b78ec6eebeb33b2e11009b7e4d0444',
            ],
        ];
    }
}
