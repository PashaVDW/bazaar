<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LandingPage extends Model
{
    protected $fillable = [
        'business_id',
        'slug',
        'logo_path',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Component::class)
            ->withPivot(['order', 'settings'])
            ->withTimestamps()
            ->orderBy('pivot_order');
    }

}
