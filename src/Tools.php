<?php
namespace Src;
class Tools{

    private static $images= ['image/png', 'image/jpeg', 'image/webp', 'image/tiff', 'image/ico', 'image/bmp'];

    





    /**
     * Get the value of images
     */ 
    public static function getImages()
    {
        return self::$images;
    }
}