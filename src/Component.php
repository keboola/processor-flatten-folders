<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Exception;
use Keboola\Component\BaseComponent;
use Keboola\Component\UserException;
use Keboola\Processor\FlattenFolders\FlattenStrategy\ConcatStrategy;
use Keboola\Processor\FlattenFolders\FlattenStrategy\HashSha256Strategy;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class Component extends BaseComponent
{

    private const OFFSET_FILE_TYPE = 1;
    private const OFFSET_FOLDER = 2;
    private const OFFSET_SUBFOLDER = 3;

    private const MAX_FILENAME_LENGTH = '255';

    protected function getConfigDefinitionClass(): string
    {
        return ConfigDefinition::class;
    }

    protected function getConfigClass(): string
    {
        return Config::class;
    }

    public function run(): void
    {
        /** @var Config $config */
        $config = $this->getConfig();

        $finder = new Finder();
        $dataDirPartsCount = count(explode('/', $this->getDataDir()));
        $fileSystem = new Filesystem();
        $finder
            ->notName('*.manifest')
            ->in($this->getDataDir() . '/in/files')
            ->files()
            ->in($this->getDataDir() . '/in/tables')
            ->files();

        $flattenStrategy = self::createStrategy($config->getFlattenStrategy());
        foreach ($finder as $sourceFile) {
            $pathParts = explode('/', $sourceFile->getPathname());
            if ($config->getStartingDepth() === 0 ||
                    count($pathParts) === $dataDirPartsCount + self::OFFSET_SUBFOLDER) {
                $flattenedName = $flattenStrategy->flattenPath(
                    array_splice($pathParts, $dataDirPartsCount + self::OFFSET_FOLDER)
                );
            } else {
                $fileSystem->mkdir(
                    $this->getDataDir() .
                    '/out/' .
                    $pathParts[$dataDirPartsCount + self::OFFSET_FILE_TYPE] .
                    '/' .
                    $pathParts[$dataDirPartsCount + self::OFFSET_FOLDER]
                );
                $flattenedName = $pathParts[$dataDirPartsCount + self::OFFSET_FOLDER] .
                    '/' .
                    $flattenStrategy->flattenPath(
                        array_splice($pathParts, $dataDirPartsCount + self::OFFSET_SUBFOLDER)
                    );
            }
            if (strlen($flattenedName) > self::MAX_FILENAME_LENGTH) {
                throw new UserException(sprintf(
                    'Maximum allowed flattened file name length is %d. File %s length is %d characters.',
                    self::MAX_FILENAME_LENGTH,
                    $flattenedName,
                    strlen($flattenedName)
                ));
            }
            $destination = $this->getDataDir() .
                '/out/' .
                $pathParts[$dataDirPartsCount + 1] .
                '/' .
                $flattenedName;
            $fileSystem->rename($sourceFile->getPathname(), $destination);
        }
    }

    private static function createStrategy(string $flattenStrategyName): FlattenStrategyInterface
    {
        switch ($flattenStrategyName) {
            case ConcatStrategy::STRATEGY_NAME:
                return new ConcatStrategy();
            case HashSha256Strategy::STRATEGY_NAME:
                return new HashSha256Strategy();
            default:
                throw new Exception(sprintf('unknown strategy %d', $flattenStrategyName));
        }
    }
}
