@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Products') }}</div>
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">{{ __('Create New Product') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>在庫数</th>
                                <th>メーカー名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->company->company_name }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">
                                        {{ __('View') }}
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this product?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No products found.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection