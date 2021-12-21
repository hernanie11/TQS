<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business_Category extends Model
{
    use HasFactory;
    protected $table = 'business_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'is_active'];

    public function stores(){
        return $this->hasMany(Store::class);
    }

}
