<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasTenant
{
    protected static function bootHasTenant(): void
    {
        static::creating(function ($model) {
            if (app()->has('tenant_id')) {
                $model->tenant_id = app('tenant_id');
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (app()->has('tenant_id')) {
                $builder->where('tenant_id', app('tenant_id'));
            }
        });
    }

    public function scopeWithoutTenant($query)
    {
        return $query->withoutGlobalScope('tenant');
    }
}
