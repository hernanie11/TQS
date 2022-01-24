<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redeeming_Transaction extends Model
{
    use HasFactory;
    protected $table = 'redeeming_transactions';
    protected $fillable = [
        'member_id',
        'points_redeemed',
        'transaction_datetime',
        'store_code',
        'store_name',
        'created_by'
    
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function members(){
        return $this->belongsTo(Member::class);
    }
}
