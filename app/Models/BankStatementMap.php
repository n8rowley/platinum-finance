<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankStatementMap extends Model
{
    use HasFactory;

    protected $primaryKey = 'bank_account_id';

    protected $guarded = [];

    protected $casts = [
        'amount_is_split' => 'boolean',
    ];

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }
}
