<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'user_id',
        'ad_id',
        'purchased_at',
        'quantity',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function ads()
    {
        return $this->belongsToMany(Ad::class)->withPivot('quantity')->withTimestamps();
    }
}
