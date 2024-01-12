<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'processed' => 'boolean',
    ];

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function scopeNotProcessed($query)
    {
        $query->where('processed',false)->orderBy('date','asc');
    }
}
