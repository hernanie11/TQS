<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearedPoint extends Model
{
    use HasFactory;

    protected $table = 'clearedpoints';
    protected $fillable = [
    'member_id', 
    'total_cleared_points'];

    public function members(){
        return $this->belongsTo(Member::class);
    }
}
