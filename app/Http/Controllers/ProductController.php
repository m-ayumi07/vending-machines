<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('product_name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->has('company')) {
            $query->where('company_id', $request->input('company'));
        }

        $products = $query->paginate(10);
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::pluck('name', 'id');
        return view('products.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ]);

        $product = Product::create($validatedData);

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $path = $image->store('public/products');
            $product->img_path = $path;
            $product->save();
        }

        return redirect()->route('products.show', $product)
            ->with('success', '商品を登録しました。');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $companies = Company::pluck('name', 'id');
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string',
            'img_path' => 'nullable|image|max:2048',
        ]);

        $product->update($validatedData);

        if ($request->hasFile('img_path')) {
            if ($product->img_path) {
                Storage::delete($product->img_path);
            }
            $image = $request->file('img_path');
            $path = $image->store('public/products');
            $product->img_path = $path;
            $product->save();
        }

        return redirect()->route('products.show', $product)
            ->with('success', '商品を更新しました。');
    }

    public function destroy(Product $product)
    {
        if ($product->img_path) {
            Storage::delete($product->img_path);
        }
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', '商品を削除しました。');
    }
}