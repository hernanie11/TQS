<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = ['first_name', 'last_name', 'gender', 'birthday', 'barangay', 'municipality', 'province', 'email', 'mobile_number', 'is_active', 'created_by'];
    protected $casts = [
        'is_active' => 'boolean'
        
    ];

    public function points(){
        return $this->hasMany(Point::class);
    }

    public function earningtransactions(){
        return $this->hasMany(Earning_Transaction::class);
    }

    public function redeemingtransactions(){
        return $this->hasMany(Redeeming_Transaction::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }


}
