<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarnedPoint extends Model
{
    use HasFactory;
    protected $table = 'earnedpoints';
    protected $fillable = ['member_id', 'points', 'created_by'];

    public function members(){
        return $this->belongsTo(Member::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
