<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders\FlattenStrategy;

use Keboola\Processor\FlattenFolders\FlattenStrategyInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class HashSha256Strategy implements FlattenStrategyInterface
{
    public const STRATEGY_NAME = 'hash-sha256';

    /** @var JsonEncoder */
    private $jsonEncoder;

    public function __construct()
    {
        $this->jsonEncoder = new JsonEncoder();
    }

    public function flattenPath(array $pathParts): string
    {
        return hash('sha256', $this->jsonEncode($pathParts));
    }

    private function jsonEncode(array $data): string
    {
        return (string) $this->jsonEncoder->encode(
            $data,
            JsonEncoder::FORMAT
        );
    }
}
