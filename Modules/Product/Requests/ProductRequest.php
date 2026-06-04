<?php

namespace Modules\Product\Requests;

use App\Http\Requests\BaseRequest;

class ProductRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->route('product');

        return [
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'sale_price'  => 'nullable|numeric|min:0|lt:price',
            'stock'       => 'required|integer|min:0',
            'sku'         => 'required|string|unique:products,sku,' . $id,
            'status'      => 'required|in:active,inactive',
            'image_file'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'image_files' => 'nullable|array',
            'image_files.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }
}
