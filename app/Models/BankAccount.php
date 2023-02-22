<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'number', 'bank_id'
    ];

    /** Relationship */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
