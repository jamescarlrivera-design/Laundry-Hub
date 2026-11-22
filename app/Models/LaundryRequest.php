<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Service;

class LaundryRequest extends Model
{
    // Use the requests table
     use HasFactory;
    protected $table = 'requests';

    protected $fillable = [
        'customer_id',
        'branch_id',
        'total_amount',
        'status',
    ];

    // One request belongs to one customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // One request has many request items
    public function items(): HasMany
    {
        return $this->hasMany(RequestItem::class, 'request_id');
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function service(): HasMany
    {
        return $this->hasMany(Service::class);
    }


    public function pickupInformation()
{
    return $this->belongsTo(PickupInformation::class);
}

}
