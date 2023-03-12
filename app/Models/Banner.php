<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'file_id'
    ];

    /** Accessor */
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
