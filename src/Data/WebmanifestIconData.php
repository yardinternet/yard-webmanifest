<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator\Data;

use Spatie\LaravelData\Data;

class WebmanifestIconData extends Data
{
    public function __construct(
        public string $src = get_home_url() . '/favicon.ico',
        public ?string $sizes = null,
        public ?string $type = null,
    ) {
    }
}
