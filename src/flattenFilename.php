<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

/**
 * @param array $pathParts
 * @return string
 */
function flattenFilename(array $pathParts): string
{
    return join('-', array_map(function ($pathPart) {
        return str_replace('-', '--', basename($pathPart));
    }, $pathParts));
}
