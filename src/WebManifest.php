<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator;

use Webmozart\Assert\Assert;
use Yard\WebmanifestGenerator\Data\WebManifestData;
use Yard\WebmanifestGenerator\Data\WebmanifestIconData;
use Yard\WebmanifestGenerator\Traits\Helpers;

class WebManifest
{
    use Helpers;

    private WebManifestData $webmanifestData;
    private MaskableIcon $maskableIcon;

    public function __construct()
    {
        $this->maskableIcon = new MaskableIcon();
    }

    /**
     * @return array<string, mixed> Webmanifest Json data
     */
    public function generate(): array
    {
        $this->setWebmanifestData();

        return $this->webmanifestData->toArray();
    }

    private function setWebmanifestData(): void
    {
        $this->webmanifestData = new WebManifestData(
            'standalone',
            false,
            'any',
            [
                new WebmanifestIconData(),
            ]
        );

        // Include icons when custom icon was set
        $this->setManifestIcon();
    }

    private function setManifestIcon(): void
    {
        if (false === has_site_icon()) {
            return;
        }

        $favicon = $this->getFavicon(); // get/update icon

        if (false === $favicon) {
            return;
        }

        $this->webmanifestData->icons = []; // reset icon list

        foreach ($this->getConfigList('webmanifest-generator.iconSizes') as $size) {
            Assert::integer($size);

            $icon = $this->maskableIcon->getBase64Icon($size);

            if (false === $icon) {
                $icon = $this->maskableIcon->createBase64Icon($size, $favicon);
            }

            $this->webmanifestData->addIcon($icon, "{$size}x{$size}", 'image/jpeg');
        }
    }

    private function getFavicon(): false|string
    {
        /** @phpstan-ignore-next-line */
        $icon = intval(get_option('site_icon'));

        $faviconPath = get_attached_file($icon); // get full path to image

        if (false === $faviconPath || false === file_exists($faviconPath)) {
            return false;
        }

        return file_get_contents($faviconPath);
    }
}
