<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class WebManifestData extends Data
{
    public string $lang;
    public string $name;
    public string $short_name;
    public string $description;
    public string $start_url;
    public string $display;
    public bool $prefer_related_applications;
    public string $orientation;
    /** @var Collection<int, WebmanifestIconData> */
    public Collection $icons;
    public string $background_color;
    public string $theme_color;
}
