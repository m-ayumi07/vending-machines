@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">商品一覧</div>

                    <div class="card-body">
                        <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="search" class="form-control" placeholder="商品名を検索" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <select name="maker" class="form-control">
                                        <option value="">メーカーを選択</option>
                                        @foreach ($makers as $id => $name)
                                            <option value="{{ $id }}" {{ request('maker') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
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
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" width="50">
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price) }}円</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->maker->name }}</td>
                                        <td>
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">詳細</a>
                                            @auth
                                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">編集</a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</button>
                                                </form>