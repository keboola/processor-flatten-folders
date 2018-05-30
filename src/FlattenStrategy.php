<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

interface FlattenStrategy
{
    public function flattenPath(array $pathParts): string;
}
