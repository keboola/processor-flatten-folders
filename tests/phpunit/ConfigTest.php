<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\Config;
use Keboola\Processor\FlattenFolders\ConfigDefinition;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testGetDepth(): void
    {
        $config = new Config(
            [
                'parameters' => [
                    'starting_depth' => 1,
                ],
            ],
            new ConfigDefinition()
        );
        self::assertEquals(1, $config->getStartingDepth());
    }
}
