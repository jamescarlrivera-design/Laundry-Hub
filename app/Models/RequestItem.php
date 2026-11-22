<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'service_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // Each item belongs to one request
    public function request(): BelongsTo
    {
        return $this->belongsTo(LaundryRequest::class, 'request_id');
    }

    // Each item belongs to one service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
