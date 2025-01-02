<?php

declare(strict_types=1);

namespace Yard\Webmanifest\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Yard\Webmanifest\Data\IconData;
use Yard\Webmanifest\MaskableIcon;
use Yard\Webmanifest\Traits\Helpers;

class IconController extends Controller
{
	use Helpers;

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

		$configuredSizes = $this->getConfigList('iconSizes');

		// return 404 if wrong file name or if size is not in config
		abort_if(null === $iconData || false === in_array($iconData?->size ?? null, $configuredSizes), 404);

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

		$icon = $this->maskableIcon->getBase64Icon($iconData);

		if ('' === $icon) {
			$icon = $this->maskableIcon->createBase64Icon($iconData, $favicon);
		}

		return base64_decode($icon) ?: '';
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
