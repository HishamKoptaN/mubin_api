<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'status',
        'online_offline',
        'account_number',
        'token',
        'name',
        'username',
        'password',
        'email',
        'image',
        'address',
        'phone',
        'phone_verified_at',
        'balance',
        'phone_verification_code',
        'inactivate_end_at',
        'upgraded_at',
        'comment',
        'refcode',
        'account_info',
        'balance',
        'confirmation_code',
        'reset_code',
        'refered_by',
        'plan_id',
        'role'
    ];

 
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
   
    public function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        );
    }
    public function upgradedDate(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => $this->upgraded_at ? $this->upgraded_at->format('Y-m-d H:i') : null,
        );
    }
    public function refer()
    {
        return $this->belongsTo(User::class, 'refered_by');
    }
    public function referrals()
    {
        return $this->hasMany(User::class, 'refered_by');
    }
  
    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'user_id');
    }
    public function adminTransfers()
    {
        return $this->hasMany(Transfer::class, 'admin_id');
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_tasks');
    }
    public function userPlan()
    {
        return $this->hasOne(UserPlan::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
