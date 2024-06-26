<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Product;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
        ]);

        $sale = Sale::create($request->all());

        return redirect()->route('sales.index')->with('success', '販売記録が作成されました。');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
        ]);

        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', '販売記録が更新されました。');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success', '販売記録が削除されました。');
    }

    // API用の購入処理
    public function buy(Request $request)
    {
        $product_model = new Product();
        $sale_model = new Sale();

        $id = $request->input('product_id');
        $product = $product_model->getProductById($id);

        // 商品なし
        if (!$product) {
            return response()->json('商品がありません');
        }

        // 在庫なし
        if ($product->stock <= 0) {
            return response()->json('在庫がありません');
        }

        try {
            DB::beginTransaction();
            // productsテーブルのstock減算
            $buy = $sale_model->decStock($id);
            // salesテーブルにインサート
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