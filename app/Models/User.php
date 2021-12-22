<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'username',
        'is_active',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'access_permission' => 'json',
        'is_active' => 'boolean'
        
    ];

    public function accountroles(){
        return $this->hasMany(Account_Role::class);
    }

    public function members(){
        return $this->hasMany(Member::class);
    }

    public function points(){
        return $this->hasMany(EarnedPoint::class);
    }

    public function earnings(){
        return $this->hasMany(Earning::class);
    }

    public function earning_transactions(){
        return $this->hasMany(Earning_Transaction::class);
    }

    public function redeeming_transactions(){
        return $this->hasMany(Redeeming_Transaction::class);
    }
}
