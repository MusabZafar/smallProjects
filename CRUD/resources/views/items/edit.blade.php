@extends('items.layout')

@section('content')

<div class="premium-card" style="max-width: 650px; margin: 0 auto;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="premium-heading">Edit Vehicle</h2>
            <p class="sub-header mb-0">Modify current attributes and rental configurations for this vehicle.</p>
        </div>
        <a class="btn-modern btn-modern-secondary" href="{{ route('items.index') }}">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label-modern">Product / Car Model</label>
            <input type="text"
                   name="product"
                   class="form-control form-control-modern @error('product') is-invalid @enderror"
                   placeholder="e.g. Toyota Corolla"
                   value="{{ old('product', $item->product) }}">
            @error('product')
                <div class="text-danger small mt-2"><i class="fa fa-circle-exclamation me-1"></i> {{ $message }}</div>
            @enderror
        </div>

        @php
            $catName = $item->categoryRel->name ?? $item->category;
        @endphp
        <div class="mb-4">
            <label class="form-label-modern">Category / Type</label>
            <input type="text"
                   name="category"
                   class="form-control form-control-modern @error('category') is-invalid @enderror"
                   placeholder="e.g. SUV, Economy, Luxury"
                   value="{{ old('category', $catName) }}">
            @error('category')
                <div class="text-danger small mt-2"><i class="fa fa-circle-exclamation me-1"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <label class="form-label-modern">Available Stock Quantity</label>
                <input type="number"
                       name="quantity"
                       class="form-control form-control-modern @error('quantity') is-invalid @enderror"
                       placeholder="e.g. 10"
                       value="{{ old('quantity', $item->quantity) }}">
                @error('quantity')
                    <div class="text-danger small mt-2"><i class="fa fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label-modern">Price per Day ($)</label>
                <input type="number"
                       name="price"
                       class="form-control form-control-modern @error('price') is-invalid @enderror"
                       placeholder="e.g. 50"
                       value="{{ old('price', $item->price) }}">
                @error('price')
                    <div class="text-danger small mt-2"><i class="fa fa-circle-exclamation me-1"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-5">
            <a href="{{ route('items.index') }}" class="btn-modern btn-modern-secondary">Cancel</a>
            <button type="submit" class="btn-modern btn-modern-primary">
                <i class="fa fa-sync-alt"></i> Update
            </button>
        </div>
    </form>
</div>

@endsection
