<?php

namespace Modules\Product\Models;

use App\Models\BaseModel;
use App\Traits\HasTenant;

class Product extends BaseModel
{
    use HasTenant;

    protected $fillable = [
        'tenant_id', 'name', 'slug', 'description',
        'price', 'sale_price', 'stock', 'sku',
        'image', 'images', 'status', 'category_id',
    ];

    protected $casts = [
        'images' => 'array',
        'price'  => 'decimal:2',
    ];

    protected array $filterable = ['name', 'sku', 'status'];
    protected array $sortable   = ['name', 'price', 'created_at'];

    public function getImageUrlAttribute(): ?string
    {
        return image_url($this->image);
    }
}
