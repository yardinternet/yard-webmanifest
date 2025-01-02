<?php

declare(strict_types=1);

namespace Yard\Webmanifest;

use Intervention\Image\ImageManager;
use Yard\Webmanifest\Data\IconData;

class MaskableIcon
{
	public function __construct(private ImageManager $imageManager)
	{
	}

	public function getIcon(IconData $iconData): string
	{
		$icon = get_transient($iconData->getFileName());

		return is_string($icon) ? $icon : '';
	}

	public function createIcon(IconData $iconData, string $originalIcon): string
	{
		$icon = $this->makeIconMaskable($iconData->size, $originalIcon);

		set_transient($iconData->getFileName(), $icon, WEEK_IN_SECONDS); // cache icon

		return $icon;
	}

	private function makeIconMaskable(int $size, string $originalIcon): string
	{
		// add 40% padding
		$newIconSize = (int) round($size - ($size * 0.4));

		// load and shrink icon
		$icon = $this->imageManager->read($originalIcon)->resize($newIconSize, $newIconSize);

		// merge icon with bg layer
		$bg = $this->imageManager->create($size, $size)->place($icon, 'center');

		return (string) $bg->toPng();
	}
}
