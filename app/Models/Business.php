<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'kvk_number',
        'vat_number',
        'phone',
        'address',
        'notes',
        'contract_status',
        'contract_file_path',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
