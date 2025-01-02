<?php

declare(strict_types=1);

namespace Yard\Webmanifest\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;
use Yard\Webmanifest\MaskableIcon;

class IconData extends Data
{
	public string $name = 'icon'; // may not contain underscores
	public int $size = 0;
	public string $extension = MaskableIcon::IMAGE_TYPE['extension']; // may not contain dots

	public static function fromConfiguredSizes(): Collection
	{
		$sizes = collect(config('webmanifest.iconSizes'));

		return $sizes->map(function (int $size) {
			return IconData::from([
				'size' => $size,
			]);
		});
	}

	/**
	 * @return string fileName in format [name]_[size].[extention]. Example icon_512.png
	 */
	public function getFileName(): string
	{
		return "{$this->name}_{$this->size}.{$this->extension}";
	}

	public static function fromFileName(string $fileName): ?self
	{
		$iconNameAndsuffix = explode('_', $fileName);

		if (2 !== count($iconNameAndsuffix)) {
			return null;
		}

		Assert::string($iconNameAndsuffix[1]);

		$sizeAndExtention = explode('.', $iconNameAndsuffix[1]);

		if (2 !== count($sizeAndExtention)) {
			return null;
		}

		return IconData::from([
			'name' => $iconNameAndsuffix[0],
			'size' => $sizeAndExtention[0],
			'extension' => $sizeAndExtention[1],
		]);
	}
}
