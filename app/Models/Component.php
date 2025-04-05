<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Component extends Model
{
    protected $fillable = [
        'name',
        'view_path',
    ];

    public function landingPages(): BelongsToMany
    {
        return $this->belongsToMany(LandingPage::class)
            ->withPivot(['order', 'settings'])
            ->withTimestamps()
            ->orderBy('pivot_order');
    }
}
