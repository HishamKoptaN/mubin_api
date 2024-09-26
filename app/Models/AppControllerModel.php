<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppControllerModel extends Model
{
    use HasFactory;
    protected $table = 'controllers';
    protected $fillable = ['status'];
}
