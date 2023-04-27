<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCheck extends Model
{
    use HasFactory;
    
    public function children(){
        return $this->hasMany('App\\Models\\BankCheck','parent_id');
    }
}
