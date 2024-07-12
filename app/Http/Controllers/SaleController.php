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
        $id = $request->input('product_id');
        $product = Product::find($id);

        if (!$product) {
            return response()->json('商品がありません', 404);
        }

        if ($product->stock <= 0) {
            return response()->json('在庫がありません', 400);
        }

        try {
            DB::beginTransaction();
            $product->decrementStock();
            Sale::createSale($product->id);
            DB::commit();

            return response()->json([
                'message' => '購入成功',
                'product' => $product
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