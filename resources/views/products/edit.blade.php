@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品編集</h1>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="company_id">メーカー</label>
            <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror" required>
                <option value="">選択してください</option>
                <option value="1" {{ $product->company_id == 1 ? 'selected' : '' }}>Coca-Cola</option>
                <option value="2" {{ $product->company_id == 2 ? 'selected' : '' }}>サントリー</option>
                <option value="3" {{ $product->company_id == 3 ? 'selected' : '' }}>キリン</option>
                <option value="4" {{ $product->company_id == 4 ? 'selected' : '' }}>その他</option>
            </select>
            @error('company_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="product_name">商品名</label>
            <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name', $product->product_name) }}" required>
            @error('product_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">価格</label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
            @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">在庫数</label>
            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required>
            @error('stock')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="comment">コメント</label>
            <textarea name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $product->comment) }}</textarea>
            @error('comment')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="img_path">商品画像</label>
            <input type="file" name="img_path" id="img_path" class="form-control-file @error('img_path') is-invalid @enderror">
            @error('img_path')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @if ($product->img_path)
                <img src="{{ asset('storage/' . $product->img_path) }}" alt="{{ $product->product_name }}" class="img-thumbnail mt-3" style="max-width: 200px;">
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">戻る</a>
        </div>
    </form>
</div>
@endsection