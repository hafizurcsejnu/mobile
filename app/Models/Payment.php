<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    public function children(){
        return $this->hasMany('App\\Models\\ProductCategory','parent_id');
    }
}
