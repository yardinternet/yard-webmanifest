<?php

declare(strict_types=1);

use Yard\Webmanifest\Data\IconData;
use Yard\Webmanifest\MaskableIcon;

it('can create filename', function () {
	$iconData = IconData::from([
		'name' => 'testIcon',
		'size' => 512,
		'extension' => 'png',
	]);

	expect($iconData->getFileName())->tobe('testIcon_512.png');
});

it('can get base64 icon from transiet', function () {
	$maskableIcon = new MaskableIcon(\Intervention\Image\ImageManager::gd());

	$iconData = IconData::from([
		'name' => 'testIcon',
		'size' => 512,
		'extension' => 'png',
	]);

	WP_Mock::userFunction('get_transient')
		->once()
		->with($iconData->getFileName())
		->andReturn('ICON BASE64');

	expect($maskableIcon->getBase64Icon($iconData))->tobe('ICON BASE64');
});
