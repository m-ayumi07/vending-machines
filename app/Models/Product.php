<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'company_id', 'product_name', 'price', 'stock', 'comment', 'img_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function decrementStock($amount = 1)
    {
        if ($this->stock >= $amount) {
            $this->decrement('stock', $amount);
            return true;
        }
        return false;
    }
}