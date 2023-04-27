<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use DB;

class Product extends Model
{
    use HasFactory;
    
    public function category(){
        return $this->belongsTo(ProductCategory::class);
    }
    public function sub_category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function popularity(){
        return $this->hasMany('App\Models\OrderDetail');
    }
}
