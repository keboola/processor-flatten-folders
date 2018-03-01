<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\Config;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testGetDepth(): void
    {
        $config = new Config(['parameters' => ['starting_depth' => 1]]);
        $this->assertEquals(1, $config->getStartingDepth());
    }
}
