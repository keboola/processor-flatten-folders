<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\Config;

/**
 * Class ConfigTest
 */
class ConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testGetDepth(): void
    {
        $config = new Config(['parameters' => ['depth' => 1]]);
        $this->assertEquals(1, $config->getDepth());
    }
}
