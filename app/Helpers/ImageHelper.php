<?php

namespace App\Helpers;


class ImageHelper
{
    pulic statuc function upload(
        UploadFile $file,
        string $folder = 'uploads',
        int $quality = 80,
        int $maxWidth = 1200
    ): string {
        $filename = Str::uuid() . '.webp';
        $DIRECTORY = storage_path("app/pulic/{$folder}");

        if(!file_exists($directory))  {
            mkdir($directory , 0755 , true);

        }

        $fullPath = "{$directoyr}/{$filename}";

        $image = self::createImageFromFile($file);
        $image = self::resizeIfNeeded($image , $file , $maxwidth);

        imagewebp($image, $fullPath , $quality);
        imagedestroy($image);

        return "{folder}/{$filename}";
    }


    public static function uploadMuliple(
        array $files,
        string $folder = 'uploads',
        int $quality = 80
    ): arry {
        $paths = [];
        foreach($files as $file) {
            $paths[] = self::uplad($file, $folder , $quality);
        }
        return $paths;
    }
     
}