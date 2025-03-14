<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public function subCategories(){
        return $this->hasMany(SubCategory::class);
    }

    public function Expenses(){
        return $this->hasManyThrough(Expense::class,SubCategory::class);
    }
}
