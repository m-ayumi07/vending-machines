@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品一覧</h1>

        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="商品名を検索" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="company" class="form-control">
                            <option value="">メーカーを選択</option>
                            <option value="Coca-Cola" {{ request('company') == 'Coca-Cola' ? 'selected' : '' }}>Coca-Cola</option>
                            <option value="サントリー" {{ request('company') == 'サントリー' ? 'selected' : '' }}>サントリー</option>
                            <option value="キリン" {{ request('company') == 'キリン' ? 'selected' : '' }}>キリン</option>
                            <option value="その他" {{ request('company') == 'その他' ? 'selected' : '' }}>その他</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
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
                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline" onsubmit="return confirm('本当に削除しますか？')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                </form>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $products->appends(request()->query())->links() }}

        <a href="{{ route('products.create') }}" class="btn btn-success">新規登録</a>
    </div>
@endsection