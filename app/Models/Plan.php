<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'user_amount_per_referal',
        'refered_amount',
        'amount_after_count',
        'count',
        'Transfer commission',
        'discount',
        'discount_type',
        'daily_transfer_count',
        'monthly_transfer_count',
        'max_transfer_count',
        "selling_price",
        "buying_price",
    ];

    public function users()
    {
    return $this->hasMany(UserPlan::class);
    }
}