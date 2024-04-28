<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('products')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.stock',
                'companies.name as company_name'
            )
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->where('products.deleted_at', null);

        if ($request->has('product_name')) {
            $query->where('products.name', 'like', '%' . $request->input('product_name') . '%');
        }

        if ($request->has('company_id')) {
            $query->where('products.company_id', $request->input('company_id'));
        }

        $products = $query->paginate(10);

        return view('products.index', compact('products'));
    }
}