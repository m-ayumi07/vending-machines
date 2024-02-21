@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品詳細</h1>

        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->image ? asset($product->image) : asset('images/default.jpg') }}" class="img-fluid" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>メーカー: {{ $product->manufacturer->name }}</p>
                <p>価格: {{ number_format($product->price) }}円</p>
                <p>在庫数: {{ $product->stock }}</p>
                <p>コメント: {{ $product->comment }}</p>

                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">編集</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
            </div>
        </div>
    </div>
@endsection