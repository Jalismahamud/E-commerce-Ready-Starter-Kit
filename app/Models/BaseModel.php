<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use Filterable, SoftDeletes;

    protected array $filterable = [];
    protected array $sortable   = ['created_at', 'updated_at'];
}
