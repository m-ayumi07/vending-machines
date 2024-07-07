<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Product;

class SaleController extends Controller
{
    public function buy(Request $request)
    {
        $product_model = new Product();
        $sale_model = new Sale();

        $id = $request->input('product_id');
        $product = product::find($id);


        if (!$product) {
            return response()->json('商品がありません');
        }

        if ($product->stock <= 0) {
            return response()->json('在庫がありません');
        }

        try {
            DB::beginTransaction();
            $buy = $sale_model->decStock($id);
            $sale_model->registSale($id);
            DB::commit();

            return response()->json([
                'message' => '購入成功',
                'product' => $buy
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => '購入失敗',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}