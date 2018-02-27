<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\Config\BaseConfigDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class ConfigDefinition
 *
 * ConfigDefinition for the processor
 *
 * @package Keboola\Processor\FlattenFolders
 */
class ConfigDefinition extends BaseConfigDefinition
{
    public function getParametersDefinition(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root("parameters");
        // @formatter:off
        $rootNode
            ->children()
                ->integerNode("depth")
                    ->min(0)
                    ->max(1)
                    ->defaultValue(0)
                ->end()
            ->end()
        ;
        // @formatter:on
        return $treeBuilder;
    }
}
