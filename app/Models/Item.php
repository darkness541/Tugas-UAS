<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['sku', 'name', 'category_id', 'minimum_stock', 'current_stock', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
