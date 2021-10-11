<?php

declare(strict_types=1);

use PHPUnitCoverageChecker\Cli\Cli;
use PHPUnitCoverageChecker\Cli\CliColors;
use PHPUnitCoverageChecker\CoverageChecker;

const STATUS_OK = 0;
const STATUS_ERROR = 1;

$cwd = isset($_SERVER['PWD']) && is_dir($_SERVER['PWD']) ? $_SERVER['PWD'] : getcwd();
// Set up autoloader
$loader = false;
if (file_exists($autoloadFile = __DIR__ . '/vendor/autoload.php')
    || file_exists($autoloadFile = __DIR__ . '/../autoload.php')
    || file_exists($autoloadFile = __DIR__ . '/../../autoload.php')
) {
    $loader = include_once($autoloadFile);
} else {
    throw new \Exception("Could not locate autoload.php. cwd is $cwd; __DIR__ is " . __DIR__);
}

$cli = new Cli(new CliColors());

try {
    $coverage_checker = CoverageChecker::fromScriptArguments(
        $cli->getArguments(),
        $cli->getOptions()
    );
} catch (InvalidArgumentException $e) {
    $cli->error($e->getMessage());
    exit(STATUS_ERROR);
}

$output = $coverage_checker->getOutput();
$coverage_checker->validates() ? $cli->success($output) : $cli->error($output);

if (array_key_exists('exit-on-low-coverage', $cli->getOptions()) && !$coverage_checker->validates()) {
    exit(STATUS_ERROR);
}
exit(STATUS_OK);

// See calculation: https://confluence.atlassian.com/pages/viewpage.action?pageId=79986990
