<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Yard\WebmanifestGenerator\WebManifest;

Route::get(
    '/' . config('webmanifest-generator.url'),
    function (WebManifest $webmanifest) {
        return response($webmanifest->generate(), 200)
            ->header('Content-Type', 'application/json');
        ;
    }
);
