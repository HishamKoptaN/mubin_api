<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'api';
    protected $fillable = [
        'status',
        'online_offline',
        'account_number',
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
     public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_user');
    }
    public function role()
    {
        return $this->belongsTo(
            Role::class,
        );
    }
    public function userRoles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_users',
            'user_id',
            'role_id',
        );
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_user', 'user_id', 'notification_id');
    }
    public function getStatusAttribute($value)
    {
        return (bool) $value;
    }


    public function createdDate(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value) => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        );
    }
    public function upgradedDate(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value) => $this->upgraded_at ? $this->upgraded_at->format('Y-m-d H:i') : null,
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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
