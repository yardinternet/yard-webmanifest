<?php

declare(strict_types=1);

namespace Yard\Webmanifest;

use Yard\Webmanifest\Data\IconData;
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

		if ('' !== $this->getConfig('theme_color')) {
			$webmanifest['themeColor'] = $this->getConfig('theme_color');
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
		$icons = IconData::fromConfiguredSizes();

		$this->webmanifestData->icons = $icons->map(function (IconData $icon) {
			return WebmanifestIconData::from([
				'src' => route('webmanifest.icon.route', $icon->getFileName()),
				'sizes' => "{$icon->size}x{$icon->size}",
				'type' => 'image/png',
			]);
		});
	}
}
