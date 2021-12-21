<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Role extends Model
{
    use HasFactory;
    protected $table = 'account_roles';
    protected $fillable = ['user_id', 'role', 'access_permission', 'updated_at'];

    protected $casts = [
        'access_permission'=>'json',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
