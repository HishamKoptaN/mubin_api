<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'notifiable_id',
        'message',
        'read_at',
    ];
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
