<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function upload(
        UploadedFile $file,
        string $folder = 'uploads',
        int $quality = 80,
        int $maxWidth = 1200
    ): string {
        $filename  = Str::uuid() . '.webp';
        $directory = storage_path("app/public/{$folder}");

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $fullPath = "{$directory}/{$filename}";

        $image = self::createImageFromFile($file);
        $image = self::resizeIfNeeded($image, $file, $maxWidth);

        imagewebp($image, $fullPath, $quality);
        imagedestroy($image);

        return "{$folder}/{$filename}";
    }

    public static function uploadMultiple(
        array $files,
        string $folder = 'uploads',
        int $quality = 80
    ): array {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = self::upload($file, $folder, $quality);
        }
        return $paths;
    }

    public static function delete(?string $path): bool
    {
        if (!$path) return false;
        return Storage::disk('public')->delete($path);
    }

    public static function deleteMultiple(array $paths): void
    {
        foreach ($paths as $path) {
            self::delete($path);
        }
    }

    public static function url(?string $path): ?string
    {
        if (!$path) return null;
        return Storage::disk('public')->url($path);
    }

    private static function createImageFromFile(UploadedFile $file)
    {
        $mime = $file->getMimeType();

        return match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($file->getRealPath()),
            'image/png'  => imagecreatefrompng($file->getRealPath()),
            'image/webp' => imagecreatefromwebp($file->getRealPath()),
            'image/gif'  => imagecreatefromgif($file->getRealPath()),
            default      => imagecreatefromjpeg($file->getRealPath()),
        };
    }

    private static function resizeIfNeeded($image, UploadedFile $file, int $maxWidth)
    {
        $origWidth  = imagesx($image);
        $origHeight = imagesy($image);

        if ($origWidth <= $maxWidth) {
            return $image;
        }

        $ratio     = $maxWidth / $origWidth;
        $newWidth  = $maxWidth;
        $newHeight = (int) ($origHeight * $ratio);

        $resized = imagecreatetruecolor($newWidth, $newHeight);

        if (in_array($file->getMimeType(), ['image/png', 'image/webp', 'image/gif'])) {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
        }

        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        imagedestroy($image);

        return $resized;
    }
}
