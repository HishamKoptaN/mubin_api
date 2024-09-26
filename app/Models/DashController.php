<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashController extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'controllers';

    // Define the fillable fields
    protected $fillable = [
        'branch_branch',
        'status',
    ];
}
