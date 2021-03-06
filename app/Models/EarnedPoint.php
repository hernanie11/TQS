<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarnedPoint extends Model
{
    use HasFactory;
    protected $table = 'earnedpoints';
    protected $fillable = ['store_id','member_id', 'transaction_no', 'amount', 'points_earn', 'transaction_datetime', 'created_by', 'category', 'is_cleared', 'cleared_datetime'];

    protected $casts = [
        'points_earn'=>'decimal:2',
        'is_cleared' => 'boolean',
      
    ];
    public function members(){
        return $this->belongsTo(Member::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
   
}
