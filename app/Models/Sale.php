<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'sale_date',
    ];

    /**
     * Get the product that owns the sale.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}