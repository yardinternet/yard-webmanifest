<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator;

use Yard\WebmanifestGenerator\Traits\Helpers;

class WebManifest
{
    use Helpers;

    private array $webmanifestData;
    private MaskableIcon $maskableIcon;

    public function __construct()
    {
        $this->maskableIcon = new MaskableIcon();
    }


    public function generate(): array
    {
        $this->setWebmanifestData();

        return $this->webmanifestData;
    }


    private function setWebmanifestData(): void
    {
        $pageName = get_bloginfo('name');
        $this->webmanifestData = [
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
        ];

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

        $this->webmanifestData['icons'] = []; // reset icon list

        foreach (config('webmanifest.iconSizes', []) as $size) {
            $icon = $this->maskableIcon->getBase64Icon($size);

            if (false === $icon) {
                $icon = $this->maskableIcon->createBase64Icon($size, $favicon);
            }

            $this->webmanifestData['icons'][] = [
                'src' => $icon,
                'sizes' => "{$size}x{$size}",
                'type' => 'image/jpeg',
            ];
        }
    }

    private function getFavicon(): false|string
    {
        $faviconPath = get_attached_file((int)get_option('site_icon')); // get full path to image

        if (false === file_exists($faviconPath)) {
            return false;
        }

        return file_get_contents($faviconPath);
    }
}
