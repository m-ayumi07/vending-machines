@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product Details') }}</div>

                <div class="card-body">
                    <div class="form-group row">
                        <label for="product_name" class="col-md-4 col-form-label text-md-right">{{ __('Product Name') }}</label>
                        <div class="col-md-6">
                            <input id="product_name" type="text" class="form-control" name="product_name" value="{{ $product->product_name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>
                        <div class="col-md-6">
                            <input id="price" type="text" class="form-control" name="price" value="{{ $product->price }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>
                        <div class="col-md-6">
                            <input id="company" type="text" class="form-control" name="company" value="{{ $product->company->company_name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection