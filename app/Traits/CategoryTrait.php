<?php
namespace App\Traits;

use App\Models\ProductCategory;

trait CategoryTrait
{
    public static function getCategories(){
        $categories = ProductCategory::where('parent_id',NULL)->orderBy('name', 'asc')->with('children')->get();
        return $categories;
    }
}
