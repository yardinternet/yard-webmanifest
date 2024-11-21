<?php

declare(strict_types=1);

namespace Yard\Webmanifest;

use Webmozart\Assert\Assert;
use Yard\Webmanifest\Data\WebManifestData;
use Yard\Webmanifest\Data\WebmanifestIconData;
use Yard\Webmanifest\Traits\Helpers;

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

        if (0 < count($this->getConfigList('icons', []))) {
            $this->setConfiguredManifestIcons();
        } elseif (true === has_site_icon()) {
            $this->setFaviconManifestIcons();
        }

        return $this->webmanifestData->toJson();
    }

    private function setManifestData(): void
    {
        $pageName = get_bloginfo('name');


        $webmanifest = [
            'lang' => get_bloginfo('language'),
            'name' => $pageName,
            'shortName' => strlen($pageName) > 11 ? substr($pageName, 0, 8) . '...' : $pageName,
            'display' => 'standalone',
            'description' => get_bloginfo('description'),
            'preferRelatedApplications' => false,
            'orientation' => 'any',
            'startUrl' => get_bloginfo('url'),
            'icons' => [ // default icon
                [
                    'src' => get_home_url() . '/favicon.ico',
                ],
            ],
        ];

        if ('' !== $this->getConfig('background_color')) {
            $webmanifest['backgroundColor'] = $this->getConfig('background_color');
        }

        if ('' !== $this->getConfig('themeColor')) {
            $webmanifest['themeColor'] = $this->getConfig('themeColor');
        }


        $this->webmanifestData = WebManifestData::from(
            $webmanifest
        );
    }

    private function setConfiguredManifestIcons(): void
    {
        $this->webmanifestData->icons = collect(); // reset icon list

        foreach ($this->getConfigList('icons') as $icon) {
            $this->webmanifestData->icons->push(WebmanifestIconData::from($icon));
        }
    }

    private function setFaviconManifestIcons(): void
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
                'type' => 'image/png',
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
