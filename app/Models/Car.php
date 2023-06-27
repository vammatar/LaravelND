<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function scopeFilter(Builder $query, $filter)
    {
        if ($filter->brand != null) {
            $query->where('brand', 'like', "%$filter->brand%");
        }

        if ($filter->model != null) {
            $query->where('model', 'like', "%$filter->model%");
        }
    }
}
