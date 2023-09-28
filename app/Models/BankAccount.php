<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $casts = [
        'file_map' => 'object',
        'enabled' => 'boolean',
    ];

    protected $guarded = [];

    protected $with = ['statementMap'];

    protected $appends = ['has_statement_map'];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function statementMap(){
        return $this->hasOne(BankStatementMap::class);
    }

    public function getHasStatementMapAttribute(){
        return $this->statementMap()->exists();
    }
}


