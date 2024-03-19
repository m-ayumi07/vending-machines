@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>{{ __('Sales') }}</div>
                        <div>
                            <a href="{{ route('sales.create') }}" class="btn btn-primary">{{ __('Create New Sale') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>@sortablelink('id', __('ID'))</th>
                                <th>@sortablelink('product.product_name', __('Product'))</th>
                                <th>@sortablelink('quantity', __('Quantity'))</th>
                                <th>@sortablelink('sale_date', __('Sale Date'))</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->product->product_name }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>{{ $sale->sale_date->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-primary">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this sale?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No sales found.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection