<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\Config\BaseConfigDefinition;
use Keboola\Processor\FlattenFolders\FlattenStrategy\ConcatStrategy;
use Keboola\Processor\FlattenFolders\FlattenStrategy\HashSha256Strategy;
use PhpParser\Node\Expr\AssignOp\Concat;
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
                    ->values([
                        ConcatStrategy::STRATEGY_NAME,
                        HashSha256Strategy::STRATEGY_NAME,
                    ])
                    ->defaultValue(ConcatStrategy::STRATEGY_NAME)
                ->end()
            ->end()
        ;
        // @formatter:on
        return $parametersNode;
    }
}
