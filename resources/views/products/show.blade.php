@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細</h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    @if ($product->img_path)
                        <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" class="img-fluid mb-3">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="img-fluid mb-3">
                    @endif
                </div>
                <div class="col-md-6">
                    <h2>{{ $product->product_name }}</h2>
                    <p><strong>メーカー:</strong> {{ $product->company->company_name }}</p>
                    <p><strong>価格:</strong> {{ number_format($product->price) }}円</p>
                    <p><strong>在庫数:</strong> {{ $product->stock }}</p>
                    <p><strong>コメント:</strong> {{ $product->comment }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">編集</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>
@endsection