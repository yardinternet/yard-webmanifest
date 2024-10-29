<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator\Data;

use Spatie\LaravelData\Data;

class WebmanifestIconData extends Data
{
    public string $src;
    public string $sizes;
    public string $type;
}
