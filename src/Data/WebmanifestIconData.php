<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator\Data;

use Spatie\LaravelData\Data;
use Yard\WebmanifestGenerator\Traits\Helpers;

class WebmanifestIconData extends Data
{
    use Helpers;

    public function __construct(
        public ?string $src = null,
        public ?string $sizes = null,
        public ?string $type = null,
    ) {
        if (null === $src) {
            $this->src = $this->getDefaultFaviconPath();
        }
    }
}
