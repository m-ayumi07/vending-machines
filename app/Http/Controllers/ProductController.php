<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('company');

        if ($request->input('search')) {
            $query->where('product_name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->input('company')) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('id', $request->input('company'));
            });
        }

        $products = $query->paginate(10);
        $companies = Company::all();

        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'product_name' => 'required|max:255',
                'company_id' => 'required|exists:companies,id',
                'price' => 'required|integer|min:0',
                'stock' => 'required|integer|min:0',
                'comment' => 'nullable|string',
                'img_path' => 'nullable|image|max:2048',
            ]);

            $product = new Product();
            $product->product_name = $validatedData['product_name'];
            $product->company_id = $validatedData['company_id'];
            $product->price = $validatedData['price'];
            $product->stock = $validatedData['stock'];
            $product->comment = $validatedData['comment'];

            if ($request->hasFile('img_path')) {
                $image = $request->file('img_path');
                $path = $image->store('public/products');
                $product->img_path = $path;
            }

            $product->save();

            return redirect()->route('products.index')
                ->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load('company');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        try {
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

            return redirect()->route('products.index')
                ->with('success', '商品を更新しました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->img_path) {
                Storage::delete($product->img_path);
            }
            $product->delete();

            return redirect()->route('products.index')
                ->with('success', '商品を削除しました。');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}