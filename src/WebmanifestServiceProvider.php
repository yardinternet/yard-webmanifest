<?php

declare(strict_types=1);

namespace Yard\Webmanifest;

use Intervention\Image\ImageManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WebmanifestServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('webmanifest')
			->hasConfigFile()
			->hasRoute('web');
	}

	public function packageRegistered(): void
	{
		$this->app->bind(MaskableIcon::class, function () {
			return new MaskableIcon(ImageManager::gd());
		});
	}

	public function packageBooted(): void
	{
		add_action('wp_head', $this->addManifestLinkToHead(...));
	}

	public function addManifestLinkToHead(): void
	{
		$manifestPath = config('webmanifest.url');

		echo "<link rel='manifest' href='{$manifestPath}'>\n";
	}
}
