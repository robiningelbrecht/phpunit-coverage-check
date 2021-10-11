[![Build Status](https://travis-ci.org/richardregeer/phpunit-coverage-check.svg?branch=master)](https://travis-ci.org/richardregeer/phpunit-coverage-check)

# phpunit-coverage-check
This php script will read the clover xml report from phpunit and calculates the coverage score. Based on the given threshold the script will exit ok of the coverage is higher then the threshold or exit with code 1 if the coverage is lower then the threshold.
This script can be used in your continuous deployment environment or for example added to a pre-commit hook.

# Installation
The script can be installed using composer. Add this repository as a dependency to the composer.json file.

```bash
composer require --dev robiningelbrecht/phpunit-coverage-check
```

# Usage
The script has requires 2 parameters that are mandatory to return the code coverage.

1. The location of the clover xml file, that's generated by phpunit.
2. The coverage threshold that is acceptable. Min = 1, Max = 100

Generate the `clover.xml` file by using phpunit and run the coverage check script:
Run the script:

```bash
vendor/bin/phpunit --coverage-clover clover.xml
vendor/bin/coverage-check clover.xml 80
vendor/bin/coverage-check clover.xml 80 --only-percentage
```

With the `--only-percentage` enabled, the CLI command will only return the resulting coverage percentage.

It's also possible to add the coverage report generation to the phpunit.xml.dist add to following line to the xml file:

```xml
<logging>
    <log type="coverage-clover" target="clover.xml"/>
</logging>
```

For more information see the [phpunit documentation](https://phpunit.de/manual/5.3/en/index.html).
Information about the [configuration file](https://phpunit.de/manual/5.3/en/appendixes.configuration.html#appendixes.configuration) and [commandline options](https://phpunit.de/manual/current/en/textui.html#textui.clioptions).
