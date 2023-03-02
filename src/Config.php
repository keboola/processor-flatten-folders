<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\Config\BaseConfig;

class Config extends BaseConfig
{
    public function getStartingDepth(): int
    {
        return $this->getIntValue(['parameters', 'starting_depth']);
    }

    public function getFlattenStrategy(): string
    {
        return $this->getStringValue(['parameters', 'flatten_strategy']);
    }
}
