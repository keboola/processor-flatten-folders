<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\FlattenStrategy;

use Keboola\Processor\FlattenFolders\FlattenStrategyInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class HashStrategy implements FlattenStrategyInterface
{
    public const STRATEGY_NAME = 'hash';

    /** @var JsonEncoder  */
    private $jsonEncoder;

    public function __construct()
    {
        $this->jsonEncoder = new JsonEncoder();
    }

    public function flattenPath(array $pathParts): string
    {
        return sha1($this->jsonEncoder->encode(
            $pathParts,
            JsonEncoder::FORMAT
        ));
    }
}
