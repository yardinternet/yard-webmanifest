<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Yard\WebmanifestGenerator\WebManifest;

Route::get(
    '/' . config('webmanifest.url'),
    function (WebManifest $webmanifest) {
        return response()->json($webmanifest->generate());
    }
);
