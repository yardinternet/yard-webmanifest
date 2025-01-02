<?php

declare(strict_types=1);

namespace Yard\Webmanifest\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Yard\Webmanifest\Data\IconData;
use Yard\Webmanifest\MaskableIcon;

class IconController extends Controller
{
	public function __construct(private MaskableIcon $maskableIcon)
	{
	}

	/**
	 * @param string $fileName must be in format '[name]_[size].[extention]'
	 *
	 * @return void
	 */
	public function index(string $iconName): Response
	{
		$iconData = $this->parseIconName($iconName);

		abort_if(null === $iconData, 404);

		$icon = $this->getIcon($iconData);

		return response($icon)->header('Content-Type', MaskableIcon::IMAGE_TYPE['mime']);
	}

	private function parseIconName(string $iconName): ?IconData
	{
		return IconData::fromFileName($iconName);
	}

	private function getIcon(IconData $iconData): string
	{
		$favicon = $this->getFavicon();

		if ('' === $favicon) {
			return '';
		}

		$icon = $this->maskableIcon->getIcon($iconData);

		if ('' === $icon) {
			$icon = $this->maskableIcon->createIcon($iconData, $favicon);
		}

		return $icon;
	}

	private function getFavicon(): string
	{
		$icon = intval(get_option('site_icon'));

		$faviconPath = get_attached_file($icon); // get full path to image

		if (false === $faviconPath || false === file_exists($faviconPath)) {
			return '';
		}

		return file_get_contents($faviconPath) ?: '';
	}
}
