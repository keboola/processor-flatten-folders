<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\FlattenStrategy;

use Keboola\Processor\FlattenFolders\FlattenStrategyInterface;

class HashStrategy implements FlattenStrategyInterface
{
    public const STRATEGY_NAME = 'hash';

    public function flattenPath(array $pathParts): string
    {
        // TODO: Implement flattenPath() method.
    }
}
