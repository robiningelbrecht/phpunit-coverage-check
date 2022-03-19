# phpunit-coverage-check
[![CI](https://github.com/robiningelbrecht/phpunit-coverage-check/actions/workflows/main.yml/badge.svg?branch=master)](https://github.com/robiningelbrecht/phpunit-coverage-check/actions/workflows/main.yml)
[![codecov](https://codecov.io/gh/robiningelbrecht/phpunit-coverage-check/branch/master/graph/badge.svg?token=W8QR00MSP7)](https://codecov.io/gh/robiningelbrecht/phpunit-coverage-check)

This php script will read the clover xml report from phpunit and calculates the coverage score. Based on the given threshold the script will exit ok of the coverage is higher then the threshold or exit with code 1 if the coverage is lower then the threshold.
This script can be used in your continuous deployment environment or for example added to a pre-commit hook.

# Installation
The script can be installed using composer. Add this repository as a dependency to the composer.json file.

```bash
composer require --dev robiningelbrecht/phpunit-coverage-check dev-master
```
# Usage

Generate the coverage file by using phpunit and run the coverage check script:

```bash
vendor/bin/phpunit --coverage-clover clover.xml
vendor/bin/coverage-checker clover.xml 80
```
# Available arguments and options

```diff
Command coverage-checker, version 1.0

Check the code coverage using the clover or text report of phpunit

Usage: coverage-checker [OPTIONS...] [ARGUMENTS...]

Arguments:
  <file>                           The location of the file that's generated by phpunit
  <percentage>                     The coverage threshold that is acceptable. Min = 1, Max = 100

Options:
  [-f|--formatter]                 Formatter to use ("message" by default)
  [-p|--processor]                 Processor to use ("clover-coverage" by default)  
  [-m|--enabled-metrics]           Metrics to use when calculating coverage. Defaults to all
  [-elc|--exit-on-low-coverage]    Exit the script when low coverage is detected. Defaults to "false"
  [-h|--help]                      Show help
  [-v|--verbosity]                 Verbosity level
  [-V|--version]                   Show version

Legend: <required> [optional] variadic...
```
