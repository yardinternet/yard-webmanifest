<?php

declare(strict_types=1);

return [
    'url' => '/manifest.webmanifest',
    'iconSizes' => [192, 384, 512, 1024],

    // Default Theme settings
    // https://developer.mozilla.org/en-US/docs/Web/Manifest/background_color
    // https://developer.mozilla.org/en-US/docs/Web/Manifest/theme_color
    'background_color' => '',
    'theme_color' => '',

    /**
     * Set icons manually
     * allowed attributes are: src, sizes, type, purpose
     *
     * Example:
     *
     * 'icons' => [
     *   [
     *      'src' => 'path/to/icon.png',
     *      'sizes' => '192x192',
     *      'type' => 'image/png',
     *   ],
     * ],
     */
    'icons' => [],
];
