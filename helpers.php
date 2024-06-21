<?php

if (!function_exists("bb_resize")) {
    function bb_resize(int $fileId, int $width = 0, int $height = 0, int $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL): string
    {
        $picture = \CFile::ResizeImageGet($fileId, ['width' => $width, 'height' => $height], $resizeType);
        return (string)$picture['src'];
    }
}