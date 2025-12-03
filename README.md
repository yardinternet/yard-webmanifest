# Yard webmanifest-generator

[![Code Style](https://github.com/yardinternet/yard-webmanifest/actions/workflows/format-php.yml/badge.svg?no-cache)](https://github.com/yardinternet/yard-webmanifest/actions/workflows/format-php.yml)
[![PHPStan](https://github.com/yardinternet/yard-webmanifest/actions/workflows/phpstan.yml/badge.svg?no-cache)](https://github.com/yardinternet/yard-webmanifest/actions/workflows/phpstan.yml)
[![Tests](https://github.com/yardinternet/yard-webmanifest/actions/workflows/run-tests.yml/badge.svg?no-cache)](https://github.com/yardinternet/yard-webmanifest/actions/workflows/run-tests.yml)
[![Code Coverage Badge](https://github.com/yardinternet/yard-webmanifest/blob/badges/coverage.svg)](https://github.com/yardinternet/yard-webmanifest/actions/workflows/badges.yml)
[![Lines of Code Badge](https://github.com/yardinternet/yard-webmanifest/blob/badges/lines-of-code.svg)](https://github.com/yardinternet/yard-webmanifest/actions/workflows/badges.yml)

## Requirements

- [Sage](https://github.com/roots/sage) >= 10.0
- [Acorn](https://github.com/roots/acorn) >= 4.0

## Installation

To install this package using Composer, follow these steps:

1. Add the following to the `repositories` section of your `composer.json`:

    ```json
    {
      "type": "vcs",
      "url": "git@github.com:yardinternet/yard-webmanifest.git"
    }
    ```

2. Install this package with Composer:

    ```sh
    composer require yard/webmanifest
    ```

3. Run the Acorn WP-CLI command to discover this package:

    ```shell
    wp acorn package:discover
    ```

You can publish the config file with:

```shell
wp acorn vendor:publish --provider="Yard\Webmanifest\WebmanifestServiceProvider"
```

## Usage

In theory you don't have to do anything, the Webmanifest works out of the box.
This packages uses the favicon set in the theme to generate icons.

But you can alter behavior via the configuration.

### Manually configuring icons

You can do this by adding them to the `icons` array in the [config](./config/webmanifest.php)

```php
'icons' => [
  [
    'src' => 'path/to/icon.png',
    'sizes' => '192x192',
    'type' => 'image/png',
  ],
],
```

### Theme settings

You can set the background and theme color by changing the config values below.

```php
'background_color' => '#add8eb',
'theme_color' => '#ffffff',
```

### Icon sizes

```php
'iconSizes' => [192, 384, 512, 1024],
```

### Webmanifest URL path

```php
'url' => '/manifest.webmanifest',
```

### Webmanifest icons url

```php
'iconUrl' => '/webmanifest/icon',
```

## About us

[![banner](https://raw.githubusercontent.com/yardinternet/.github/refs/heads/main/profile/assets/small-banner-github.svg)](https://www.yard.nl/werken-bij/)
