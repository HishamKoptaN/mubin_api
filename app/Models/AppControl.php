<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppControl extends Model
{
    use HasFactory;
    protected $table = 'app_controls';
    protected $fillable = [
        'branch_name',
        'status',
        'message',
    ];
    public function getStatusAttribute($value)
    {
        return (bool) $value;
    }
}
