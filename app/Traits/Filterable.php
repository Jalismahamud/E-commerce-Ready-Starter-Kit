<?php

namespace App\Traits;

trait Filterable
{
    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $field => $value) {
            if (!empty($value) && in_array($field, $this->filterable ?? [])) {
                $query->where($field, 'like', "%{$value}%");
            }
        }
        return $query;
    }

    public function scopeSortBy($query, $column = 'created_at', $direction = 'desc')
    {
        $allowed = $this->sortable ?? ['created_at', 'updated_at'];
        if (in_array($column, $allowed)) {
            $query->orderBy($column, $direction);
        }
        return $query;
    }
}
