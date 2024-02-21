@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品一覧</h1>

        <form action="{{ route('products.index') }}" method="get">
            <div class="form-group">
                <label for="search">商品名</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ $search }}">
            </div>

            <div class="form-group">
                <label for="manufacturer">メーカー</label>
                <select class="form-control" id="manufacturer" name="manufacturer">
                    <option value="">選択してください</option>
                    @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->id }}" @if ($manufacturer->id == $selectedManufacturer) selected @endif>{{ $manufacturer->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">検索</button>
        </form>

        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">新規登録</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">商品名</th>
                    <th scope="col">価格</th>
                    <th scope="col">在庫数</th>
                    <th scope="col">メーカー</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->manufacturer->name }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection