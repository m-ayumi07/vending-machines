@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品編集</h1>

        <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="manufacturer">メーカー</label>
                <select class="form-control @error('manufacturer_id') is-invalid @enderror" id="manufacturer" name="manufacturer_id">
                    <option value="">選択してください</option>
                    @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->id }}" @if (old('manufacturer_id', $product->manufacturer_id) == $manufacturer->id) selected @endif>{{ $manufacturer->name }}</option>
                    @endforeach
                </select>
                @error('manufacturer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">価格</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">在庫数</label>
                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="comment">コメント</label>
                <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment">{{ old('comment', $product->comment) }}</textarea>
                @error('comment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">商品画像</label>
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <img src="{{ $product->image ? asset($product->image) : asset('images/default.jpg') }}" class="img-fluid mt-3" alt="{{ $product->name }}">
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">戻る</a>
        </form>
    </div>
@endsection