<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
