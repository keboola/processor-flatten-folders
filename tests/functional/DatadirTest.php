<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\FunctionalTests;

use Keboola\DatadirTests\DatadirTestCase;
use Keboola\DatadirTests\DatadirTestsProviderInterface;

class DatadirTest extends DatadirTestCase
{
    /**
     * @return DatadirTestsProviderInterface[]
     */
    protected function getDataProviders(): array
    {
        return [
            new DatadirTestProvider($this->getTestFileDir()),
        ];
    }
}
