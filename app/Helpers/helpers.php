<?php

use App\Helpers\ImageHelper;
use Illuminate\Http\UploadedFile;

if (!function_exists('upload_image')) {
    function upload_image(UploadedFile $file, string $folder = 'uploads', int $quality = 80): string
    {
        return ImageHelper::upload($file, $folder, $quality);
    }
}

if (!function_exists('delete_image')) {
    function delete_image(?string $path): bool
    {
        return ImageHelper::delete($path);
    }
}

if (!function_exists('image_url')) {
    function image_url(?string $path): ?string
    {
        return ImageHelper::url($path);
    }
}

if (!function_exists('format_amount')) {
    function format_amount($amount, string $currency = 'BDT'): string
    {
        return $currency . ' ' . number_format($amount, 2);
    }
}

if (!function_exists('generate_code')) {
    function generate_code(string $prefix = '', int $length = 8): string
    {
        return strtoupper($prefix . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length));
    }
}

if (!function_exists('paginate_response')) {
    function paginate_response($paginator, string $message = 'Success'): array
    {
        return [
            'status'  => true,
            'message' => $message,
            'data'    => $paginator->items(),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ],
        ];
    }
}

if (!function_exists('active_tenant')) {
    function active_tenant()
    {
        return app()->has('tenant') ? app('tenant') : null;
    }
}
