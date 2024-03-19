<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
    ];

    /**
     * Get the products for the company.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}