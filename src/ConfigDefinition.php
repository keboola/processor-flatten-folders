<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\Config\BaseConfigDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ConfigDefinition extends BaseConfigDefinition
{
    /**
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    public function getParametersDefinition()
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
        return $rootNode;
    }
}
