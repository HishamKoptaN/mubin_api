<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
class Rate extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'status',
        'plan_id',
        'from',
        'to',
        'selling',
        'buying', 'created_at',
        'updated_at',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from');
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to');
    }

    public function getStatusAttribute($value)
    {
        return $value === 'active';
    }

    public function getFromCurrencyNameAttribute()
    {
        return $this->fromCurrency ? $this->fromCurrency->name : null;
    }

    public function getToCurrencyNameAttribute()
    {
        return $this->toCurrency ? $this->toCurrency->name : null;
    }
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => Carbon::parse($value)->format('Y-m-d H:i'),
        );
    }
    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => Carbon::parse($value)->format('Y-m-d H:i'),
        );
    }
}
