<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class WebManifestData extends Data
{
    #[Computed]
    public string $lang;
    #[Computed]
    public string $name;
    #[Computed]
    public string $short_name;
    #[Computed]
    public string $description;
    #[Computed]
    public string $start_url;

    /**
     * Web app manifests data
     *
     * @param string $display
     * @param bool $prefer_related_applications
     * @param string $orientation
     * @param array<int, WebmanifestIconData> $icons
     */
    public function __construct(
        public string $display,
        public bool $prefer_related_applications,
        public string $orientation,
        #[DataCollectionOf(WebmanifestIconData::class)]
        public array $icons = [],
    ) {
        $pageName = get_bloginfo('name');

        $this->lang = get_bloginfo('language');
        $this->name = $pageName;
        $this->short_name = strlen($pageName) > 11 ? substr($pageName, 0, 8) . '...' : $pageName;
        $this->description = get_bloginfo('description');
        $this->start_url = get_bloginfo('url');
    }

    public function addIcon(string $src, string $sizes, string $type): void
    {
        $this->icons[] = new WebmanifestIconData($src, $sizes, $type);
    }
}
