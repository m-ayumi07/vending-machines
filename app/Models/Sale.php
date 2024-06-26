<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['product_id'];

    // 減算処理
    public function decStock($id)
    {
        // 減算
        DB::table('products')
            ->where('id', '=', $id)
            ->decrement('stock');

        // 減算後の情報を返却
        $afterBuy = DB::table('products')
            ->select('id', 'product_name', 'stock')
            ->where('id', '=', $id)
            ->first();

        return $afterBuy;
    }

    // salesテーブルインサート処理
    public function registSale($id)
    {
        DB::table('sales')
            ->insert([
                'product_id' => $id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    // リレーション定義
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}