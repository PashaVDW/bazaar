<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'stock_index',
        'start_time',
        'end_time',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function returnRequest()
    {
        return $this->hasOne(ReturnRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
