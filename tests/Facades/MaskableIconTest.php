<?php

declare(strict_types=1);

use Yard\Webmanifest\MaskableIcon;

it('can get base64 icon from transiet', function () {
	$maskableIcon = new MaskableIcon(\Intervention\Image\ImageManager::gd());

	$size = 192;

	WP_Mock::userFunction('get_transient')
		->once()
		->with("Base64 icon {$size}px")
		->andReturn('ICON BASE64');

	expect($maskableIcon->getBase64Icon($size))->tobe('ICON BASE64');
});
