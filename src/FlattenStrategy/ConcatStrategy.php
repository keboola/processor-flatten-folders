<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\FlattenStrategy;

use Keboola\Processor\FlattenFolders\FlattenStrategy;

class ConcatStrategy implements FlattenStrategy
{
    public function flattenPath(array $pathParts): string
    {
        return join('-', array_map(function ($pathPart) {
            return str_replace('-', '--', basename($pathPart));
        }, $pathParts));
    }
}
