<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ad_id',
        'name',
        'description',
        'price',
        'type',
        'stock',
        'image',
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class)->withPivot('quantity')->withTimestamps();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }

    public function scopeSub($query)
    {
        return $query->where('is_main', false);
    }
}
