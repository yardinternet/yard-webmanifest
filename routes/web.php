<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Yard\Webmanifest\WebManifest;

Route::get(
	config('webmanifest.url'),
	function (WebManifest $webmanifest) {
		return response($webmanifest->generate(), 200)->
			header('Content-Type', 'application/json');
	}
)->name('webmanifest.manifest');

Route::get(config('webmanifest.iconUrl').'/{iconName}', [\Yard\Webmanifest\Http\Controllers\IconController::class, 'index'])->name('webmanifest.icon');
