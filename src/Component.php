<?php

declare(strict_types=1);

namespace Keboola\Processor\FlattenFolders;

use Keboola\Component\BaseComponent;
use Symfony\Component\Filesystem\Filesystem;

class Component extends BaseComponent
{

    private const OFFSET_FILE_TYPE = 1;
    private const OFFSET_FOLDER = 2;
    private const OFFSET_SUBFOLDER = 3;

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

        $finder = new \Symfony\Component\Finder\Finder();
        $dataDirPartsCount = count(explode('/', $this->getDataDir()));
        $fileSystem = new Filesystem();
        $finder
            ->notName('*.manifest')
            ->in($this->getDataDir() . '/in/files')
            ->files()
            ->in($this->getDataDir() . '/in/tables')
            ->files()
        ;
        foreach ($finder as $sourceFile) {
            $pathParts = explode('/', $sourceFile->getPathname());
            if ($config->getStartingDepth() === 0 || count($pathParts) === $dataDirPartsCount + self::OFFSET_SUBFOLDER) {
                $flattenedName = flattenPath(array_splice($pathParts, $dataDirPartsCount + self::OFFSET_FOLDER));
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
                    flattenPath(array_splice($pathParts, $dataDirPartsCount + self::OFFSET_SUBFOLDER));
            }
            $destination = $this->getDataDir() .
                '/out/' .
                $pathParts[$dataDirPartsCount + 1] .
                '/' .
                $flattenedName;
            $fileSystem->rename($sourceFile->getPathname(), $destination);
        }
    }
}
