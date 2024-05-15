<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 商品一覧画面表示
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // 商品新規登録画面表示
    public function create()
    {
        return view('products.create');
    }

    // 商品新規登録処理
    public function store(Request $request)
    {
        // バリデーション、データ保存処理...

        return redirect()->route('products.index');
    }

    // 商品詳細画面表示
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // 商品編集画面表示
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // 商品更新処理
    public function update(Request $request, Product $product)
    {
        // バリデーション、データ更新処理...

        return redirect()->route('products.show', $product);
    }

    // 商品削除処理
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}