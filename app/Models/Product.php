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
        'product_name', 'company_id', 'price', 'stock', 'comment', 'img_payh','created_at'
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