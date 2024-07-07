<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('company');

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('company')) {
            $query->where('company_id', $request->input('company'));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->input('stock_min'));
        }

        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->input('stock_max'));
        }

        if ($request->has('sort') && $request->has('order')) {
            $sort = $request->input('sort');
            $order = $request->input('order');

            if ($sort === 'company_id') {
                $query->join('companies', 'products.company_id', '=', 'companies.id')
                      ->orderBy('companies.company_name', $order)
                      ->select('products.*');
            } else {
                $query->orderBy($sort, $order);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(10);
        $companies = Company::all();

        if ($request->ajax()) {
            return view('products.index', compact('products', 'companies'))->render();
        }

        return view('products.index', compact('products', 'companies'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    public function store(ArticleRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $product = new Product();
            $product->product_name = $validatedData['product_name'];
            $product->company_id = $validatedData['company_id'];
            $product->price = $validatedData['price'];
            $product->stock = $validatedData['stock'];
            $product->comment = $validatedData['comment'];

            if ($request->hasFile('img_path')) {
                $image = $request->file('img_path');
                $path = $image->store('products', 'public');
                $product->img_path = $path;
            }

            $product->save();

            Log::info('Image path: ' . $product->img_path);
            if (Storage::disk('public')->exists($product->img_path)) {
                Log::info('File exists: ' . $product->img_path);
            } else {
                Log::warning('File does not exist: ' . $product->img_path);
            }

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

    public function update(ArticleRequest $request, Product $product)
    {
        try {
            $validatedData = $request->validated();

            $product->update($validatedData);

            if ($request->hasFile('img_path')) {
                if ($product->img_path) {
                    Storage::disk('public')->delete($product->img_path);
                }
                $image = $request->file('img_path');
                $path = $image->store('products', 'public');
                $product->img_path = $path;
                $product->save();
            }

            Log::info('Image path: ' . $product->img_path);
            if (Storage::disk('public')->exists($product->img_path)) {
                Log::info('File exists: ' . $product->img_path);
            } else {
                Log::warning('File does not exist: ' . $product->img_path);
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
                Storage::disk('public')->delete($product->img_path);
            }
            $product->delete();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => '商品を削除しました。']);
            }

            return redirect()->route('products.index')
                ->with('success', '商品を削除しました。');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'エラーが発生しました。'], 500);
            }
            return redirect()->back()->withErrors('削除中にエラーが発生しました。');
        }
    }
}