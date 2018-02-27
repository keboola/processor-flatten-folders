<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\Tests;

use Keboola\Processor\FlattenFolders\ConfigDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class ConfigDefinitionTest
 */
class ConfigDefinitionTest extends \PHPUnit\Framework\TestCase
{
    public function testValidEmptyConfigDefinition(): void
    {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $processedConfig = $processor->processConfiguration($definition, []);
        $expectedConfig = [
            "parameters" => [
                "depth" => 0,
            ],
        ];
        $this->assertSame($expectedConfig, $processedConfig);
    }

    public function testValidConfigDefinition(): void
    {
        $definition = new ConfigDefinition();
        $processor = new Processor();
        $validConfigDefinition = ['parameters' => ['depth' => 1]];
        $processedConfig = $processor->processConfiguration($definition, [$validConfigDefinition]);
        $expectedConfig = [
            "parameters" => [
                "depth" => 1,
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
                ['parameters' => ['depth' => 'invalid']],
                InvalidConfigurationException::class,
                'The child node "baseUrl" at path "parameters" must be configured.',
            ],
        ];
    }
}
