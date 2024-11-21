<?php

declare(strict_types=1);

namespace Yard\Webmanifest;

use Intervention\Image\ImageManager;

class MaskableIcon
{
    public function __construct(private ImageManager $imageManager)
    {
    }

    public function getBase64Icon(int $size): string
    {
        //        $icon = get_transient($this->getTransientName($size));
        $icon = null;

        return is_string($icon) ? $icon : '';
    }

    public function createBase64Icon(int $size, string $favicon): string
    {
        $base64Icon = $this->makeIconMaskable($size, $favicon);

        set_transient($this->getTransientName($size), $base64Icon, WEEK_IN_SECONDS); // cache icon

        return $base64Icon;
    }

    private function getTransientName(int $size): string
    {
        return "Base64 icon {$size}px";
    }

    private function makeIconMaskable(int $size, string $favicon): string
    {
        // add 40% padding
        $newIconSize = (int) round($size - ($size * 0.4));

        // load and shrink icon
        $icon = $this->imageManager->read($favicon)->resize($newIconSize, $newIconSize);


        // merge icon with bg layer
        $bg = $this->imageManager->create($size, $size)->place($icon, 'center');

        return 'data:image/png;base64,' . base64_encode((string) $bg->toPng());
    }
}
