<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function getCategoryAttribute(){ // May need to make a scope that can be queried
        return $this->subCategory->category;
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function scopeGroupedExpenseData($query)
    {
        $query->select(
            'categories.name as category_name',
            'sub_categories.name as sub_category_name',
            'expenses.description as expense_name',
            DB::raw('SUM(expenses.amount) as expense_total')
        )
        ->join('sub_categories', 'expenses.sub_category_id', '=', 'sub_categories.id')
        ->join('categories', 'sub_categories.category_id', '=', 'categories.id')
        ->groupBy('categories.name', 'sub_categories.name', 'expenses.description')
        ->orderBy('categories.name')
        ->orderBy('sub_categories.name');
    }
}
