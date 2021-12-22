<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning_Transaction extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'member_id', 
        'transaction_no',
        'amount', 
        'points_earn',
        'transaction_datetime'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function members(){
        return $this->belongsTo(Member::class);
    }
}
