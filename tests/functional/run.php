<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

$testFolder = __DIR__;

$finder = new \Symfony\Component\Finder\Finder();
$finder->directories()->sortByName()->in($testFolder)->depth(0);
foreach ($finder as $testSuite) {
    print 'Test ' . $testSuite->getPathname() . PHP_EOL;
    $temp = new \Keboola\Temp\Temp('processor-decompress');
    $temp->initRunFolder();

    $copyCommand = 'cp -R ' . $testSuite->getPathname() . '/source/data/* ' . $temp->getTmpFolder();
    (new \Symfony\Component\Process\Process($copyCommand))->mustRun();

    if (!file_exists($temp->getTmpFolder() . '/in/tables')) {
        mkdir($temp->getTmpFolder() . '/in/tables', 0777, true);
    }
    if (!file_exists($temp->getTmpFolder() . '/in/files')) {
        mkdir($temp->getTmpFolder() . '/in/files', 0777, true);
    }

    mkdir($temp->getTmpFolder() . '/out/tables', 0777, true);
    mkdir($temp->getTmpFolder() . '/out/files', 0777, true);

    $runCommand = 'KBC_DATADIR=' . $temp->getTmpFolder() .' php /code/main.php';
    $runProcess = new \Symfony\Component\Process\Process($runCommand);
    $runProcess->mustRun();

    $diffCommand = 'diff --exclude=.gitkeep --ignore-all-space --recursive ' . $testSuite->getPathname() . '/expected/data/out ' . $temp->getTmpFolder() . '/out';
    $diffProcess = new \Symfony\Component\Process\Process($diffCommand);
    $diffProcess->run();
    if ($diffProcess->getExitCode() > 0) {
        print PHP_EOL . $diffProcess->getOutput() . PHP_EOL;
        exit(1);
    }
}
