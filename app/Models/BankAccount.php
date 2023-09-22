<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $casts = [
        'file_map' => 'object',
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    public function getMappableAttribute(){
        return $this->file_map != null;
    }

    public function scopeMappable($query){
        return $query->whereNotNull('file_map');
    }
}


