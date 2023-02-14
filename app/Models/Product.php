<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price',
        'product_category_id', 'file_id'
    ];

    /** Relationship */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /** Acessor */
    public function getFormatPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

}
