<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdPurchase extends Model
{
    protected $table = 'ad_purchase';

    protected $fillable = [
        'ad_id',
        'purchase_id',
        'quantity',
    ];
}
