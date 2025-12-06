@extends('layouts.admin')
@section('title', 'Activity Logs')

@section('page-actions')

@endsection
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: var(--apb-primary);
        box-shadow: 0 0 0 0.25rem rgba(20, 184, 166, 0.15);
    }

    .badge-action {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .badge-success {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .badge-warning {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .badge-info {
        background: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }

    .badge-secondary {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(20, 184, 166, 0.1);
        color: var(--apb-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }

    .table-modern tbody td {
        vertical-align: middle;
    }

    /* Keep table area height consistent whether data exists or not */
    .logs-table-card {
        min-height: 420px;
        display: flex;
        flex-direction: column;
    }

    .logs-table-card .table-responsive {
        flex: 1;
        min-height: 300px;
    }

    .logs-empty-state {
        min-height: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    /* Pagination Styles */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        color: #64748b;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 4px 8px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        min-width: 28px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.4);
        transform: scale(1.05);
    }

    .pagination .page-item.disabled .page-link {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none;
        pointer-events: none;
    }

    .pagination .page-item.disabled .page-link:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        transform: none;
        box-shadow: none;
    }

    @media (max-width: 576px) {
        .pagination-wrapper {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }

        .pagination {
            justify-content: center;
        }
    }
</style>
@endpush
@section('content')
<!-- Filters -->
<div class="filter-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-funnel me-2"></i> Filters</h5>
        <div>
            <a href="{{ route('admin.logs.index', array_merge(request()->query(), ['export' => 'csv'])) }}" class="btn btn-sm text-white" style="background: #10B981; border: none; font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
                <i class="bi bi-download me-2"></i> Export Excel
            </a>
        </div>
    </div>
    <form method="GET" action="{{ route('admin.logs.index') }}">
        <div class="row g-3 mb-3">
            <!-- Search -->
            <div class="col-md-6">
                <label class="form-label text-muted small fw-bold"><i class="bi bi-search me-1"></i> Search</label>
                <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search description, action, or user...">
            </div>
            <!-- Date Range -->
            <div class="col-md-3">
                <label class="form-label text-muted small fw-bold"><i class="bi bi-calendar3 me-1"></i> Start Date</label>
                <input type="text" name="start_date" class="form-control datepicker" placeholder="Start Date" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted small fw-bold"><i class="bi bi-calendar3 me-1"></i> End Date</label>
                <input type="text" name="end_date" class="form-control datepicker" placeholder="End Date" value="{{ $endDate }}">
            </div>
        </div>

        <div class="row g-3">
            <!-- User Filter -->
            <div class="col-md-3">
                <label class="form-label text-muted small fw-bold"><i class="bi bi-person me-1"></i> User</label>
                <select name="admin_id" class="form-select">
                    <option value="">All Users</option>
                    @foreach($admins as $admin)
                    <option value="{{ $admin->id }}" {{ $adminId == $admin->id ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Action Filter -->
            <div class="col-md-3">
                <label class="form-label text-muted small fw-bold"><i class="bi bi-lightning me-1"></i> Action</label>
                <select name="action" class="form-select">
                    <option value="">All Actions</option>
                    @foreach($actions as $act)
                    <option value="{{ $act }}" {{ $action == $act ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $act)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Show Entries -->
            <div class="col-md-2">
                <label class="form-label text-muted small fw-bold"><i class="bi bi-list-ol me-1"></i> Show</label>
                <select name="per_page" class="form-select">
                    @foreach([10,25,50,100] as $size)
                    <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Filter Button -->
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1 fw-bold" style="background: var(--apb-primary); border: none; padding: 0.6rem 1rem; border-radius: 8px;">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary flex-grow-1 fw-bold text-center text-decoration-none" style="padding: 0.6rem 1rem; border-radius: 8px;">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>
<!-- Logs Table -->
<div class="table-card logs-table-card">
    <div class="table-card-header">
        <h5>Activity Logs</h5>
        <span class="meta">{{ $logs->total() }} total entries</span>
    </div>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>

                    <th width="15%">User</th>
                    <th width="15%">Action</th>
                    <th width="35%">Description</th>
                    <th width="15%">Target</th>
                    <th width="10%">Date</th>
                    <th width="5%"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <span class="fw-semibold">{{ $log->admin->name ?? 'System' }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                        $badgeColor = match(true) {
                        str_contains(strtolower($log->action), 'delete') => 'danger',
                        str_contains(strtolower($log->action), 'create') => 'success',
                        str_contains(strtolower($log->action), 'update') => 'warning',
                        str_contains(strtolower($log->action), 'login') => 'info',
                        default => 'secondary'
                        };
                        @endphp
                        <span class="badge badge-action badge-{{ $badgeColor }}">
                            {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                        </span>
                    </td>
                    <td class="text-truncate" style="max-width: 300px;" title="{{ $log->description }}">
                        {{ $log->description }}
                    </td>
                    <td>
                        @if($log->targetUser)
                        <span class="status-pill approved">
                            <i class="bi bi-person"></i> {{ $log->targetUser->name }}
                        </span>
                        @else
                        <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-semibold">{{ $log->created_at->format('d M Y') }}</span>
                            <span class="text-muted small">{{ $log->created_at->format('H:i A') }}</span>
                        </div>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            onclick="showDetails({{ json_encode($log->details) }})"
                            title="View Details">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <div class="logs-empty-state">
                            <div class="mb-3">
                                <i class="bi bi-clipboard-x display-4 text-light"></i>
                            </div>
                            <p class="mb-0">No logs found matching your criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="position-relative mt-3 p-3 border-top">
        <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">
                <i class="bi bi-house"></i> Back to Home
            </a>
        </div>
        <div class="d-flex flex-column align-items-end">
            <div class="text-muted small mb-2">
                Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} results
            </div>
            <div>
                {{ $logs->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
    @else
    <div class="text-center mt-3 p-3 border-top">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">
            <i class="bi bi-house"></i> Back to Home
        </a>
    </div>
    @endif
</div>
<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);">
                <div>
                    <h5 class="modal-title fw-bold mb-1">
                        <i class="bi bi-info-circle-fill me-2"></i>Log Details
                    </h5>
                    <p class="mb-0 small opacity-75" id="logTimestamp"></p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Log Summary -->
                <div class="p-4 border-bottom bg-light">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-person-badge text-primary mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Performed By</small>
                                    <strong id="logUser"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-lightning-fill text-warning mt-1"></i>
                                <div>
                                    <small class="text-muted d-block">Action</small>
                                    <strong id="logAction"></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-chat-left-text text-info mt-1"></i>
                                <div class="flex-grow-1">
                                    <small class="text-muted d-block">Description</small>
                                    <strong id="logDescription"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Technical Details -->
                <div class="p-4">
                    <h6 class="fw-bold mb-3 text-muted">
                        <i class="bi bi-code-square me-2"></i>Technical Details
                    </h6>
                    <div id="detailsContent"></div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    });
    // Show Details Modal
    function showDetails(details) {
        const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
        const detailsContainer = document.getElementById('detailsContent');

        // Get log info from the clicked row
        const row = event.target.closest('tr');
        if (row) {
            const user = row.cells[1].querySelector('.fw-semibold').textContent;
            const action = row.cells[2].querySelector('.badge').textContent.trim();
            const description = row.cells[3].textContent.trim();
            const timestamp = row.cells[5].querySelector('.fw-semibold').textContent + ' ' +
                row.cells[5].querySelector('.small').textContent;

            document.getElementById('logUser').textContent = user;
            document.getElementById('logAction').textContent = action;
            document.getElementById('logDescription').textContent = description;
            document.getElementById('logTimestamp').textContent = timestamp;
        }

        // Format and display technical details
        if (details && Object.keys(details).length > 0) {
            let html = '<div class="list-group list-group-flush">';
            for (const [key, value] of Object.entries(details)) {
                const displayKey = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                const displayValue = typeof value === 'object' ? JSON.stringify(value, null, 2) : value;

                html += `
                    <div class="list-group-item px-0 py-2 border-0">
                        <div class="row align-items-start">
                            <div class="col-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary w-100 text-start">
                                    ${displayKey}
                                </span>
                            </div>
                            <div class="col-8">
                                <strong class="text-dark">${displayValue}</strong>
                            </div>
                        </div>
                    </div>
                `;
            }
            html += '</div>';
            detailsContainer.innerHTML = html;
        } else {
            detailsContainer.innerHTML = '<p class="text-muted text-center py-3"><i class="bi bi-info-circle me-2"></i>No additional technical details available.</p>';
        }

        modal.show();
    }
</script>
@endpush