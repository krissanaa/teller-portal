@extends('layouts.teller')

@section('title', 'ລາຍງານຮ້ານຄ້າຂອງຂ້ອຍ')

@section('content')
<style>
    * {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .page-header {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--apb-accent);
    }

    .page-header h4 {
        margin: 0;
        color: #212529;
        font-weight: 700;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Compact Status Cards */
.status-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
}

.status-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
}

.status-card-body {
    padding: 14px 10px;
    text-align: center;
}

.status-icon {
    font-size: 1.8rem;
    margin-bottom: 6px;
    display: block;
}

.status-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 4px;
    color: #6c757d;
}

.status-count {
    font-size: 1.6rem;
    font-weight: 700;
    line-height: 1;
    color: #212529;
}

/* Color borders */
.status-card.pending {
    border-left: 4px solid #ffc107;
}
.status-card.approved {
    border-left: 4px solid #28a745;
}
.status-card.rejected {
    border-left: 4px solid #dc3545;
}

/* Make cards more compact on mobile */
@media (max-width: 768px) {
    .status-card-body {
        padding: 12px 6px;
    }
    .status-icon {
        font-size: 1.5rem;
    }
    .status-count {
        font-size: 1.4rem;
    }
}


    /* Filter Card */
    .filter-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 24px;
        margin-bottom: 24px;
    }

    .filter-title {
        color: #212529;
        font-weight: 700;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
    }

    .filter-title i {
        color: var(--apb-accent);
    }

    .search-input, .filter-select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 11px 14px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .search-input:focus, .filter-select:focus {
        border-color: var(--apb-accent);
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
    }

    .btn-reset {
        background: white;
        border: 1px solid #ced4da;
        color: #212529;
        border-radius: 8px;
        padding: 11px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #212529;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-header {
        background: #f8f9fa;
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-header-title {
        font-weight: 700;
        color: #212529;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
    }

    .table-count {
        background: var(--apb-accent);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .modern-table {
        margin-bottom: 0;
    }

    .modern-table thead {
        background: #f8f9fa;
    }

    .modern-table thead th {
        padding: 14px 16px;
        font-weight: 600;
        border: none;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        color: #495057;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .modern-table tbody tr:hover {
        background: #f8f9fa;
    }

    .modern-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.9rem;
    }

     .store-link {
        color: #2D5F3F;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .store-link:hover {
        color: #4CAF50;
        transform: translateX(5px);
    }

    .store-link i {
        font-size: 0.9rem;
    }

    /* Status Badges */
    .badge-status {
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-status.pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
    }

    .badge-status.pending:hover {
        background: #ffc107;
        color: #000;
    }

    .badge-status.approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #28a745;
    }

    .badge-status.approved:hover {
        background: #28a745;
        color: white;
    }

    .badge-status.rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #dc3545;
    }

    .badge-status.rejected:hover {
        background: #dc3545;
        color: white;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 16px;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin: 0;
    }

    @media (max-width: 768px) {
        .status-card-body {
            padding: 16px;
        }

        .status-count {
            font-size: 2rem;
        }
    }
</style>

<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="page-header">
        <h4>
            <i class="bi bi-graph-up-arrow"></i>
            ລາຍງານຮ້ານຄ້າຂອງຂ້ອຍ
        </h4>
    </div>

    <!-- Status Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('teller.report', ['status' => 'pending']) }}" class="status-card pending">
                <div class="status-card-body">
                    <span class="status-icon">⏳</span>
                    <div class="status-label">ລໍຖ້າອະນຸມັດ</div>
                    <div class="status-count">
                        {{ \App\Models\TellerPortal\OnboardingRequest::where('teller_id', Auth::id())->where('approval_status','pending')->count() }}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('teller.report', ['status' => 'approved']) }}" class="status-card approved">
                <div class="status-card-body">
                    <span class="status-icon">✅</span>
                    <div class="status-label">ອະນຸມັດແລ້ວ</div>
                    <div class="status-count">
                        {{ \App\Models\TellerPortal\OnboardingRequest::where('teller_id', Auth::id())->where('approval_status','approved')->count() }}
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('teller.report', ['status' => 'rejected']) }}" class="status-card rejected">
                <div class="status-card-body">
                    <span class="status-icon">❌</span>
                    <div class="status-label">ປະຕິເສດ</div>
                    <div class="status-count">
                        {{ \App\Models\TellerPortal\OnboardingRequest::where('teller_id', Auth::id())->where('approval_status','rejected')->count() }}
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="filter-card">
        <div class="filter-title">
            <i class="bi bi-funnel-fill"></i>
            ກັ່ນຕອງ ແລະ ຄົ້ນຫາ
        </div>
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold text-muted small mb-2">
                    <i class="bi bi-search"></i> ຄົ້ນຫາ
                </label>
                <input type="text" name="search" value="{{ $search }}"
                       class="form-control search-input"
                       placeholder="ຊື່ຮ້ານ / ລະຫັດອ້າງອີງ / ປະເພດທຸລະກິດ"
                       onkeydown="if(event.key==='Enter'){this.form.submit();}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold text-muted small mb-2">
                    <i class="bi bi-filter"></i> ສະຖານະ
                </label>
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">-- ສະຖານະທັງໝົດ --</option>
                    <option value="pending" {{ $status=='pending' ? 'selected' : '' }}>⏳ ລໍຖ້າອະນຸມັດ</option>
                    <option value="approved" {{ $status=='approved' ? 'selected' : '' }}>✅ ອະນຸມັດແລ້ວ</option>
                    <option value="rejected" {{ $status=='rejected' ? 'selected' : '' }}>❌ ປະຕິເສດ</option>
                </select>
            </div>
            <div class="col-md-3">
                <a href="{{ route('teller.report') }}" class="btn btn-reset w-100">
                    <i class="bi bi-arrow-clockwise"></i> ລ້າງຕົວກອງ
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-header-title">
                <i class="bi bi-table"></i> ຂໍ້ມູນທັງໝົດ
            </span>
            <span class="table-count">{{ $data->total() }} ລາຍການ</span>
        </div>
        <div class="table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th width="60">ລຳດັບ</th>
                        <th>ລະຫັດອ້າງອີງ</th>
                        <th>ຊື່ຮ້ານຄ້າ</th>
                        <th>ສາຂາ</th>
                        <th>ວັນທີຕິດຕັ້ງ</th>
                        <th>ປະເພດທຸລະກິດ</th>
                        <th width="120" class="text-center">ສະຖານະ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $r)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $r->id }}</td>
                            <td>
                                <code class="text-dark">{{ $r->refer_code }}</code>
                            </td>
                            <td>
                                <a href="{{ route('teller.requests.show', $r->id) }}" class="store-link">
                                    <i class="bi bi-shop"></i>
                                    {{ $r->store_name }}
                                </a>
                            </td>
                            <td>
                                <i class="bi bi-pin-map text-muted"></i>
                                {{ $r->branch?->name ?? '-' }}
                            </td>
                            <td>
                                <i class="bi bi-calendar3 text-muted"></i>
                                {{ $r->installation_date }}
                            </td>
                            <td>{{ $r->business_type }}</td>
                            <td class="text-center">
                                @if($r->approval_status == 'approved')
                                    <a href="{{ route('teller.report', ['status' => 'approved']) }}"
                                       class="badge-status approved">
                                        Approved
                                    </a>
                                @elseif($r->approval_status == 'pending')
                                    <a href="{{ route('teller.report', ['status' => 'pending']) }}"
                                       class="badge-status pending">
                                        Pending
                                    </a>
                                @else
                                    <a href="{{ route('teller.report', ['status' => 'rejected']) }}"
                                       class="badge-status rejected">
                                        Rejected
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>ບໍ່ມີຂໍ້ມູນສຳລັບລາຍງານ</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($data->hasPages())
                <div class="px-4 pb-4">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
