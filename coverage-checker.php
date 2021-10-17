<?php

declare(strict_types=1);

use Ahc\Cli\Output\Writer;
use PHPUnitCoverageChecker\Cli\CoverageCheckerCommand;
use PHPUnitCoverageChecker\Cli\ExitStatus;
use PHPUnitCoverageChecker\Cli\Option;
use PHPUnitCoverageChecker\CoverageChecker;

$cwd = isset($_SERVER['PWD']) && is_dir($_SERVER['PWD']) ? $_SERVER['PWD'] : getcwd();
// Set up autoloader
$loader = false;
if (file_exists($autoloadFile = __DIR__.'/vendor/autoload.php')
    || file_exists($autoloadFile = __DIR__.'/../autoload.php')
    || file_exists($autoloadFile = __DIR__.'/../../autoload.php')
) {
    $loader = include_once $autoloadFile;
} else {
    throw new \Exception("Could not locate autoload.php. cwd is $cwd; __DIR__ is ".__DIR__);
}

$writer = new Writer();
$command = CoverageCheckerCommand::create();

try {
    $command->parse($_SERVER['argv']);
} catch (RuntimeException $e) {
    $writer->bgRedBold($e->getMessage(), true);
    exit(ExitStatus::error());
}

try {
    $coverage_checker = CoverageChecker::fromCommand($command);
} catch (Exception $e) {
    $writer->bgRedBold($e->getMessage(), true);
    exit(ExitStatus::error());
}

if ($output = $coverage_checker->getOutput()) {
    $coverage_checker->validates() ? $writer->bgGreenBold($output, true) : $writer->bgRedBold($output, true);
}

if (!empty($command->getOptionValues()[(string) Option::exitOnLowCoverage()]) && !$coverage_checker->validates()) {
    exit(ExitStatus::error());
}
exit(ExitStatus::ok());
