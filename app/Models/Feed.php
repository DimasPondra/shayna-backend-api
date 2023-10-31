<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'file_id'
    ];

    /** Relationship */
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
