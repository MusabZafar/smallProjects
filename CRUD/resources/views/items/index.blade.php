@extends('items.layout')

@section('content')

<!-- Live Dashboard Metrics -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <span class="d-block text-muted small uppercase fw-bold" style="letter-spacing: 0.5px;">TOTAL VEHICLES</span>
                <h3 class="mb-0 fw-bold mt-1" style="color: var(--text-main); font-size: 1.75rem;">{{ \App\Models\Item::count() }}</h3>
            </div>
            <div class="stat-icon" style="background: rgba(99, 102, 241, 0.15); color: var(--primary-accent);">
                <i class="fa fa-car-side"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <span class="d-block text-muted small uppercase fw-bold" style="letter-spacing: 0.5px;">LOW STOCK ALERTS</span>
                <h3 class="mb-0 fw-bold mt-1 text-warning" style="font-size: 1.75rem;">{{ \App\Models\Item::where('quantity', '<', 5)->count() }}</h3>
            </div>
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.15); color: var(--warning-accent);">
                <i class="fa fa-triangle-exclamation"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div>
                <span class="d-block text-muted small uppercase fw-bold" style="letter-spacing: 0.5px;">AVG DAILY RATE</span>
                <h3 class="mb-0 fw-bold mt-1" style="color: var(--info-accent); font-size: 1.75rem;">${{ round(\App\Models\Item::avg('price') ?? 0) }}/day</h3>
            </div>
            <div class="stat-icon" style="background: rgba(6, 182, 212, 0.15); color: var(--info-accent);">
                <i class="fa fa-wallet"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Panel Card -->
<div class="premium-card">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <h2 class="premium-heading">Car Fleet Listing</h2>
            <p class="sub-header mb-0">Monitor, filter, and organize rental fleet availability in real time.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn-modern btn-modern-warning" href="{{ route('items.lowstock', 5) }}">
                <i class="fa fa-filter"></i> Low Stock &lt; 5
            </a>
            <a class="btn-modern btn-modern-secondary" href="{{ route('items.index') }}">
                <i class="fa fa-list"></i> Show All
            </a>
            <a class="btn-modern btn-modern-primary" href="{{ route('items.create') }}">
                <i class="fa fa-plus-circle"></i> Add Vehicle
            </a>
        </div>
    </div>

    <!-- Alert Panel -->
    @if(session('success'))
        <div class="alert alert-modern mb-4">
            <i class="fa fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Data Table Wrapper -->
    <div class="premium-table-wrapper">
        <table class="table premium-table">
            <thead>
                <tr>
                    <th>Product / Model</th>
                    <th>Category</th>
                    <th>Stock Quantity</th>
                    <th>Daily Rate</th>
                    <th width="160px" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    @php
                        $catName = $item->categoryRel->name ?? $item->category;
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-bold text-white d-flex align-items-center gap-2">
                                <i class="fa fa-circle-play text-muted small"></i>
                                {{ $item->product }}
                            </div>
                        </td>
                        <td>
                            <span class="category-badge badge-{{ $catName ?? 'fallback' }}">
                                {{ $catName ?? 'Unassigned' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold {{ $item->quantity < 5 ? 'text-warning' : 'text-white' }}">
                                    {{ $item->quantity }}
                                </span>
                                @if($item->quantity < 5)
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-0.5 rounded-2" style="font-size: 0.7rem;">
                                        LOW
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5 rounded-2" style="font-size: 0.7rem;">
                                        OK
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-success font-monospace">${{ $item->price }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a class="btn-action btn-action-info" href="{{ route('items.show', $item) }}" title="Inspect details">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a class="btn-action btn-action-primary" href="{{ route('items.edit', $item) }}" title="Modify records">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action btn-action-danger" 
                                            title="Delete vehicle record"
                                            onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted mb-2"><i class="fa fa-folder-open fa-2x"></i></div>
                            <div class="fw-semibold text-muted">There are no data.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Styled Pagination -->
    <div class="d-flex justify-content-end mt-4">
        {!! $items->links() !!}
    </div>
</div>

@endsection
