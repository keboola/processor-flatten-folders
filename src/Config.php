<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\Config\BaseConfig;

class Config extends BaseConfig
{
    public function getDepth(): int
    {
        return $this->getValue(['parameters', 'depth']);
    }
}
