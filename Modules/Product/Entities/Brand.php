<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected function slug(): Attribute{
        return Attribute::make(
            set: fn () =>  Str::slug($this->attributes['name'])
        );
    }

    public function scopeSearch(Builder $query, $term = null)
    {
        return $query->when($term, function (Builder $query, $term) {
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('persian_name', 'like', "%{$term}%");
        });
    }
}
