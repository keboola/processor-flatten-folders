<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\ConfigDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;

class ConfigDefinitionTest extends \PHPUnit\Framework\TestCase
{
    public function testValidEmptyConfigDefinition(): void
    {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $validEmptyConfig = ['parameters' => []];
        $processedConfig = $processor->processConfiguration($definition, [$validEmptyConfig]);
        $expectedConfig = [
            'parameters' => [
                'starting_depth' => 0,
                'flatten_strategy' => 'concat',
            ],
        ];
        $this->assertSame($expectedConfig, $processedConfig);
    }

    public function testValidConfigDefinition(): void
    {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $validConfigDefinition = ['parameters' => ['starting_depth' => 1, 'flatten_strategy' => 'concat']];
        $processedConfig = $processor->processConfiguration($definition, [$validConfigDefinition]);
        $expectedConfig = [
            'parameters' => [
                'starting_depth' => 1,
                'flatten_strategy' => 'concat',
            ],
        ];
        $this->assertSame($expectedConfig, $processedConfig);
    }

    /**
     * @dataProvider provideInvalidConfigs
     */
    public function testInvalidConfigDefinition(
        array $inputConfig,
        string $expectedExceptionClass,
        string $expectedExceptionMessage
    ): void {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $this->expectException($expectedExceptionClass);
        $this->expectExceptionMessage($expectedExceptionMessage);
        $processor->processConfiguration($definition, [$inputConfig]);
    }

    /**
     * @return mixed[][]
     */
    public function provideInvalidConfigs(): array
    {
        return [
            'depth is not a number' => [
                ['parameters' => ['starting_depth' => 'invalid']],
                InvalidConfigurationException::class,
                'Invalid type for path "root.parameters.starting_depth". Expected int, but got string.',
            ],
            'depth is too large' => [
                ['parameters' => ['starting_depth' => 2]],
                InvalidConfigurationException::class,
                'The value 2 is too big for path "root.parameters.starting_depth". Should be less than or equal to 1',
            ],
            'depth is out too small' => [
                ['parameters' => ['starting_depth' => -1]],
                InvalidConfigurationException::class,
                'The value -1 is too small for path "root.parameters.starting_depth". Should be greater than or equal to 0',
            ],
            'unknown flatten strategy' => [
                ['parameters' => ['flatten_strategy' => 'random']],
                InvalidConfigurationException::class,
                'The value "random" is not allowed for path "root.parameters.flatten_strategy". Permissible values: "concat", "hash-sha256"',
            ],
        ];
    }
}
