<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name', 'number', 'status', 'bank_id'
    ];

    /** Relationship */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
