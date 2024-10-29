<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator;

use Intervention\Image\ImageManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WebmanifestGeneratorServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('webmanifest-generator')
            ->hasConfigFile()
            ->hasRoute('web');
    }

    public function packageRegistered(): void
    {
        $this->app->bind(MaskableIcon::class, function () {
            return new MaskableIcon(ImageManager::gd());
        });
    }
}
