<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 商品一覧を表示する
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $manufacturer = $request->input('manufacturer');

        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($manufacturer) {
            $query->where('manufacturer_id', $manufacturer);
        }

        $products = $query->get();

        $manufacturers = Manufacturer::all();

        return view('products.index', [
            'products' => $products,
            'manufacturers' => $manufacturers,
            'search' => $search,
            'selectedManufacturer' => $manufacturer,
        ]);
    }

    /**
     * 商品登録画面を表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manufacturers = Manufacturer::all();

        return view('products.create', [
            'manufacturers' => $manufacturers,
        ]);
    }

    /**
     * 商品を登録する
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'comment' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->manufacturer_id = $request->input('manufacturer_id');
        $product->comment = $request->input('comment');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images');
            $product->image = 'storage/' . substr($imagePath, 7);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品を登録しました。');
    }

    /**
     * 商品詳細を表示する
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', [
            'product' => $product,
        ]);
    }

    /**
     * 商品編集画面を表示する
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $manufacturers = Manufacturer::all();

        return view('products.edit', [
            'product' => $product,
            'manufacturers' => $manufacturers,
        ]);
    }

    /**
     * 商品情報を更新する
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'comment' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->manufacturer_id = $request->input('manufacturer_id');
        $product->comment = $request->input('comment');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images');
            $product->image = 'storage/' . substr($imagePath, 7);
        }

        $product->save();

        return redirect()->route('products.show', $product->id)->with('success', '商品を更新しました。');
    }

    /**
     * 商品を削除する
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}