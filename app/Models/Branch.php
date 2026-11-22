<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'branch_code',
        'address',
        'phone',
        'email',
        'status',
    ];

    public function laundryRequests(): HasMany
    {
        return $this->hasMany(LaundryRequest::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->withPivot([
                'pricing_type',
                'unit',
                'price',
                'is_active'
            ])
            ->withTimestamps();
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_id')
            ->where('role', 'staff');
    }

    
}
