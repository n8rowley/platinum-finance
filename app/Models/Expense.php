<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategory(){
        $this->belongsTo(SubCategory::class);
    }

    public function getCategoryAttribute(){ // May need to make a scope that can be queried
        return $this->subCategory->category;
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
