<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $primaryKey = 'id';
    protected $fillable = [
        'businesscategory_id',
        'code',
        'name',
        'area',
        'region',
        'cluster',
        'business_model',
        'token',
        'is_active',
        'created_by' 
    ];

    protected $casts = [
        'is_active' => 'boolean'
        
    ];

    public function businesscategory()
    {
        return $this->belongsTo(Business_Category::class);
    }


    
}
