<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_CANCELED = 'canceled';

    const STATUS_MAP = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_SUCCESS => 'Success',
        self::STATUS_CANCELED => 'Canceled'
    ];

    protected $fillable = [
        'uuid', 'sub_total', 'total',
        'status', 'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }

    /** Relationship */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /** Accessor */
    public function getFormatSubTotalAttribute()
    {
        return number_format($this->sub_total, 0, ',', '.');
    }

    public function getFormatTotalAttribute()
    {
        return number_format($this->total, 0, ',', '.');
    }
}
