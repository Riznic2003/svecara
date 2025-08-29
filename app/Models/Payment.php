<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','amount','status','reference','provider','paid_at'];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}
