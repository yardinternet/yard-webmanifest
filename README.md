# Yard webmanifest-generator

[![Code Style](https://github.com/yardinternet/webmanifest-generator/actions/workflows/format-php.yml/badge.svg?no-cache)](https://github.com/yardinternet/webmanifest-generator/actions/workflows/format-php.yml)
[![PHPStan](https://github.com/yardinternet/webmanifest-generator/actions/workflows/phpstan.yml/badge.svg?no-cache)](https://github.com/yardinternet/webmanifest-generator/actions/workflows/phpstan.yml)
[![Tests](https://github.com/yardinternet/webmanifest-generator/actions/workflows/run-tests.yml/badge.svg?no-cache)](https://github.com/yardinternet/webmanifest-generator/actions/workflows/run-tests.yml)
[![Code Coverage Badge](https://github.com/yardinternet/webmanifest-generator/blob/badges/coverage.svg)](https://github.com/yardinternet/webmanifest-generator/actions/workflows/badges.yml)
[![Lines of Code Badge](https://github.com/yardinternet/webmanifest-generator/blob/badges/lines-of-code.svg)](https://github.com/yardinternet/webmanifest-generator/actions/workflows/badges.yml)



## Requirements

- [Sage](https://github.com/roots/sage) >= 10.0
- [Acorn](https://github.com/roots/acorn) >= 4.0

## Installation

To install this package using Composer, follow these steps:

1. Add the following to the `repositories` section of your `composer.json`:

    ```json
    {
      "type": "vcs",
      "url": "git@github.com:yardinternet/webmanifest-generator.git"
    }
    ```

2. Install this package with Composer:

    ```sh
    composer require yard/webmanifest-generator
    ```

3. Run the Acorn WP-CLI command to discover this package:

    ```shell
    wp acorn package:discover
    ```

You can publish the config file with:

```shell
wp acorn vendor:publish --provider="Yard\WebmanifestGenerator\WebmanifestGeneratorServiceProvider"
```

## Usage

From a Blade template:

```blade
@include('webmanifest-generator::webmanifestgenerator')
```

From WP-CLI:

```shell
wp acorn webmanifestgenerator
```
