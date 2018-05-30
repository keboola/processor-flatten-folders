<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\Config\BaseConfigDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ConfigDefinition extends BaseConfigDefinition
{
    public function getParametersDefinition(): ArrayNodeDefinition
    {
        $parametersNode = parent::getParametersDefinition();
        // @formatter:off
        $parametersNode
            ->children()
                ->integerNode('starting_depth')
                    ->min(0)
                    ->max(1)
                    ->defaultValue(0)
                ->end()
                ->enumNode('flatten_strategy')
                    ->values(['concat', 'hash'])
                    ->defaultValue('concat')
                ->end()
            ->end()
        ;
        // @formatter:on
        return $parametersNode;
    }
}
