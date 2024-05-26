<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $products = Product::with('maker')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->maker, function ($query, $makerId) {
                $query->where('maker_id', $makerId);
            })
            ->latest()
            ->paginate(10);

        $makers = Maker::pluck('name', 'id');

        return view('products.index', compact('products', 'makers'));
    }

    public function create()
    {
        $makers = Maker::pluck('name', 'id');
        return view('products.create', compact('makers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'maker_id' => 'required|exists:makers,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::create($validatedData);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
            $product->save();
        }

        return redirect()->route('products.index')
            ->with('success', '商品を登録しました。');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $makers = Maker::pluck('name', 'id');
        return view('products.edit', compact('product', 'makers'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'maker_id' => 'required|exists:makers,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->update($validatedData);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
            $product->save();
        }

        return redirect()->route('products.index')
            ->with('success', '商品を更新しました。');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', '商品を削除しました。');
    }
}