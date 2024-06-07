<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'product_name', 'price', 'stock', 'comment', 'img_path',
    ];

    /**
     * Get the company that owns the product.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the sales for the product.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}