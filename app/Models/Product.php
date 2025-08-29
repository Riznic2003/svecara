<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'unit',
        'sku',
        'min_stock',
    ];

    public $timestamps = false;


    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
