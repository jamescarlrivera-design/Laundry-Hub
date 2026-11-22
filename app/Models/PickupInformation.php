<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickupInformation extends Model
{
    use HasFactory;
    protected $table = 'pickup_information';

    protected $fillable = [
        'user_id',
        'address',
        'contact_number',
        'landmark',
        'additional_instructions',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}