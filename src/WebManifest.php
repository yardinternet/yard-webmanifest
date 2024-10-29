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

    public function __construct(private MaskableIcon $maskableIcon)
    {
    }

    public function generate(): string
    {
        $this->setManifestData();

        if (true === has_site_icon()) {
            $this->setManifestIcons();
        }

        return $this->webmanifestData->toJson();
    }

    private function setManifestData(): void
    {
        $pageName = get_bloginfo('name');

        $this->webmanifestData = WebManifestData::from(
            [
                'lang' => get_bloginfo('language'),
                'name' => $pageName,
                'short_name' => strlen($pageName) > 11 ? substr($pageName, 0, 8) . '...' : $pageName,
                'display' => 'standalone',
                'description' => get_bloginfo('description'),
                'prefer_related_applications' => false,
                'orientation' => 'any',
                'start_url' => get_bloginfo('url'),
                'icons' => [ // default icon
                    [
                        'src' => get_home_url() . '/favicon.ico',
                    ],
                ],
                'background_color' => $this->getConfig('background_color'),
                'theme_color' => $this->getConfig('theme_color'),
            ]
        );
    }

    private function setManifestIcons(): void
    {
        $favicon = $this->getFavicon();

        if ('' === $favicon) {
            return;
        }

        $this->webmanifestData->icons = collect(); // reset icon list

        foreach ($this->getConfigList('iconSizes') as $size) {
            Assert::integer($size);

            $icon = $this->maskableIcon->getBase64Icon($size);

            if ('' === $icon) {
                $icon = $this->maskableIcon->createBase64Icon($size, $favicon);
            }

            $this->webmanifestData->icons->push(WebmanifestIconData::from([
                'src' => $icon,
                'sizes' => "{$size}x{$size}",
                'type' => 'image/jpeg',
            ]));
        }
    }

    private function getFavicon(): string
    {
        /** @phpstan-ignore-next-line */
        $icon = intval(get_option('site_icon'));

        $faviconPath = get_attached_file($icon); // get full path to image

        if (false === $faviconPath || false === file_exists($faviconPath)) {
            return '';
        }

        return file_get_contents($faviconPath) ?: '';
    }
}
