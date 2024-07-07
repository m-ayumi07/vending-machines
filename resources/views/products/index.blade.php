@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧</h1>

    <form id="search-form" action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" placeholder="商品名を検索" value="{{ old('search', request('search')) }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select name="company" class="form-control">
                        <option value="">メーカーを選択</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company', request('company')) == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">検索</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="price_min">価格 (下限)</label>
                    <input type="number" name="price_min" id="price_min" class="form-control" value="{{ old('price_min', request('price_min')) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="price_max">価格 (上限)</label>
                    <input type="number" name="price_max" id="price_max" class="form-control" value="{{ old('price_max', request('price_max')) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="stock_min">在庫数 (下限)</label>
                    <input type="number" name="stock_min" id="stock_min" class="form-control" value="{{ old('stock_min', request('stock_min')) }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="stock_max">在庫数 (上限)</label>
                    <input type="number" name="stock_max" id="stock_max" class="form-control" value="{{ old('stock_max', request('stock_max')) }}">
                </div>
            </div>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div id="product-list">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <a href="#" class="sort-link" data-column="id">ID 
                            @if(request('sort') == 'id')
                                @if(request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>商品画像</th>
                    <th>
                        <a href="#" class="sort-link" data-column="product_name">商品名
                            @if(request('sort') == 'product_name')
                                @if(request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="#" class="sort-link" data-column="price">価格
                            @if(request('sort') == 'price')
                                @if(request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="#" class="sort-link" data-column="stock">在庫数
                            @if(request('sort') == 'stock')
                                @if(request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>
                        <a href="#" class="sort-link" data-column="company_id">メーカー名
                            @if(request('sort') == 'company_id')
                                @if(request('order') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->img_path)
                                <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" width="50">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" width="50">
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ number_format($product->price) }}円</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">詳細</a>
                            @auth
                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $product->id }}">削除</button>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->appends(request()->query())->links() }}
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
</div>
@endsection