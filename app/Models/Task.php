<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'name',
        'description',
        'amount',
        'link',
        'image',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks');
    }
    public function userTasks()
    {
        return $this->hasMany(UserTask::class, 'task_id');
    }
}
