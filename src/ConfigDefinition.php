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
            ->end()
        ;
        // @formatter:on
        return $parametersNode;
    }
}
