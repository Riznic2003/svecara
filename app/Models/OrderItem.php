<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','product_id','qty','unit_price'];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
