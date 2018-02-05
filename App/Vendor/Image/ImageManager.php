<?php

namespace App\Vendor\Image;
class ImageManager
{
    public static function getInstance()
    {
        static $image = null;
        if ($image == null) {
            $image = new \Intervention\Image\ImageManager(['driver' => 'imagick']);
        }
        return $image;
    }

}