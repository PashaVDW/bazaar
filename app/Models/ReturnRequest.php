<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    protected $fillable = [
        'reservation_id',
        'photo_path',
        'submitted_at',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
