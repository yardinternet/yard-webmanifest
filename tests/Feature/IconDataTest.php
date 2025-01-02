<?php

declare(strict_types=1);

use Yard\Webmanifest\Data\IconData;

it('can create filename', function () {
	$iconData = new IconData();
	$iconData->name = 'testIcon';
	$iconData->size = 512;
	$iconData->extension = 'png';

	expect($iconData->getFileName())->tobe('testIcon_512.png');
});
