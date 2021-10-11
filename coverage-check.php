<?php

declare(strict_types=1);

use PHPUnitCoverageChecker\Cli\Cli;
use PHPUnitCoverageChecker\Cli\CliColors;
use PHPUnitCoverageChecker\CoverageChecker;

// Inspired by: https://ocramius.github.io/blog/automated-code-coverage-check-for-github-pull-requests-with-travis/

const XPATH_METRICS = '//metrics';
const STATUS_OK = 0;
const STATUS_ERROR = 1;
const METRIC_ELEMENTS = 'elements';
const METRIC_STATEMENTS = 'statements';
const METRIC_METHODS = 'methods';
const METRIC_ALL = [
    METRIC_ELEMENTS,
    METRIC_STATEMENTS,
    METRIC_METHODS,
];

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

function formatCoverage(float $number): string
{
    return sprintf('%0.2f %%', $number);
}

function loadMetrics(string $file): array
{
    $xml = new SimpleXMLElement(file_get_contents($file));

    return $xml->xpath(XPATH_METRICS);
}

function printStatus(string $msg, int $exitCode = STATUS_OK)
{
    echo $msg . PHP_EOL;
    exit($exitCode);
}

var_dump($_SERVER['argv']);

if (!isset($argv[1]) || !file_exists($argv[1])) {
    printStatus("Invalid input file {$argv[1]} provided.", STATUS_ERROR);
}

if (!isset($argv[2]) || !is_numeric($argv[2]) || intval($argv[2]) < 0 || intval($argv[2]) > 100) {
    echo "\033[31m some colored text \033[0m some white text \n";
    printStatus(
        'An integer percentage (0 - 100) must be given as second parameter.',
        STATUS_ERROR
    );
}

$onlyEchoPercentage = false;
$includedMetrics = METRIC_ALL;
foreach ($argv as $arg) {
    if ($arg === '--only-percentage') {
        $onlyEchoPercentage = true;
    } else if ($arg === '--included-metrics') {
        $includedMetrics = explode(',', $arg);
        foreach ($includedMetrics as $includedMetric) {
            if (in_array($includedMetric, METRIC_ALL)) {
                continue;
            }

            printStatus(
                'A comma separated list of metrics must be provided. Valid options are "elements", "statements" and "methods"',
                STATUS_ERROR
            );
        }
    }
}

$inputFile = $argv[1];
$percentage = min(100, max(0, (float)$argv[2]));

$elements = 0;
$coveredElements = 0;
$statements = 0;
$coveredstatements = 0;
$methods = 0;
$coveredmethods = 0;

foreach (loadMetrics($inputFile) as $metric) {
    $elements += (int)$metric['elements'];
    $coveredElements += (int)$metric['coveredelements'];
    $statements += (int)$metric['statements'];
    $coveredstatements += (int)$metric['coveredstatements'];
    $methods += (int)$metric['methods'];
    $coveredmethods += (int)$metric['coveredmethods'];
}

// See calculation: https://confluence.atlassian.com/pages/viewpage.action?pageId=79986990
$coveredMetrics = $coveredstatements + $coveredmethods + $coveredElements;
$totalMetrics = $statements + $methods + $elements;

if ($totalMetrics === 0) {
    printStatus('Insufficient data for calculation. Please add more code.', STATUS_ERROR);
}

$totalPercentageCoverage = $coveredMetrics / $totalMetrics * 100;

if ($totalPercentageCoverage < $percentage && !$onlyEchoPercentage) {
    printStatus(
        'Total code coverage is ' . formatCoverage($totalPercentageCoverage) . ' which is below the accepted ' . $percentage . '%',
        STATUS_ERROR
    );
}

if ($totalPercentageCoverage < $percentage && $onlyEchoPercentage) {
    printStatus(formatCoverage($totalPercentageCoverage), STATUS_ERROR);
}

if ($onlyEchoPercentage) {
    printStatus(formatCoverage($totalPercentageCoverage));
}

printStatus('Total code coverage is ' . formatCoverage($totalPercentageCoverage) . ' – OK!');
