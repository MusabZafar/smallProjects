@extends('items.layout')

@section('content')

<div class="premium-card" style="max-width: 650px; margin: 0 auto;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="premium-heading">Show Vehicle</h2>
            <p class="sub-header mb-0">Detailed catalog specification sheet for the selected vehicle.</p>
        </div>
        <a class="btn-modern btn-modern-secondary" href="{{ route('items.index') }}">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-12">
            <div class="p-4 rounded-4" style="background: rgba(15, 23, 42, 0.4); border: 1px solid var(--card-border);">
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom border-opacity-10 pb-3" style="border-color: var(--text-muted);">
                        <span class="text-muted fw-semibold"><i class="fa fa-car me-2"></i> PRODUCT MODEL</span>
                        <span class="fw-bold text-white fs-5">{{ $item->product }}</span>
                    </div>

                    @php
                        $catName = $item->categoryRel->name ?? $item->category;
                    @endphp
                    <div class="d-flex align-items-center justify-content-between border-bottom border-opacity-10 pb-3" style="border-color: var(--text-muted);">
                        <span class="text-muted fw-semibold"><i class="fa fa-tags me-2"></i> CATEGORY</span>
                        <span class="category-badge badge-{{ $catName ?? 'fallback' }}">{{ $catName ?? 'Unassigned' }}</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between border-bottom border-opacity-10 pb-3" style="border-color: var(--text-muted);">
                        <span class="text-muted fw-semibold"><i class="fa fa-boxes-stacked me-2"></i> QUANTITY</span>
                        <span class="fw-bold text-white">{{ $item->quantity }} available</span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pb-1">
                        <span class="text-muted fw-semibold"><i class="fa fa-dollar-sign me-2"></i> DAILY RENTAL RATE</span>
                        <span class="fw-bold text-success font-monospace fs-4">${{ $item->price }}<span class="small text-muted fw-normal" style="font-size: 0.85rem;">/day</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-5">
        <a class="btn-modern btn-modern-primary" href="{{ route('items.edit', $item) }}">
            <i class="fa fa-edit"></i> Edit Details
        </a>
    </div>
</div>

@endsection
