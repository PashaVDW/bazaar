<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'ads_starttime',
        'ads_endtime',
        'is_active',
        'qr_code_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class)->withPivot('quantity')->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function mainProduct()
    {
        return $this->hasOne(Product::class)->where('is_main', true);
    }

    public function subProducts()
    {
        return $this->hasMany(Product::class)->where('is_main', false);
    }
}
