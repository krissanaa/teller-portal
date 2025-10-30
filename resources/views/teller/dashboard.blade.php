@extends('layouts.teller')

@section('title', 'Teller Dashboard')

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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
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

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-create {
        background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
        border: none;
        color: white;
        padding: 11px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 95, 63, 0.3);
        background: linear-gradient(90deg, var(--apb-secondary) 0%, var(--apb-dark) 100%);
        color: white;
    }

    .btn-report {
        background: white;
        border: 1px solid #ced4da;
        color: #212529;
        padding: 11px 24px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-report:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #212529;
        transform: translateY(-2px);
    }

    .dashboard-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .card-header-custom {
        background: #f8f9fa;
        padding: 16px 24px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        font-weight: 700;
        color: #212529;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 1.1rem;
    }

    .card-badge {
        background: #ffc107;
        color: #000;
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
        cursor: pointer;
    }

    .modern-table tbody tr:hover {
        background: #f8f9fa;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .store-name {
        color: #212529;
        font-weight: 600;
    }

    .reference-code {
        background: #f8f9fa;
        color: #212529;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.85rem;
        border: 1px solid #e9ecef;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffc107;
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

    .pagination-wrapper {
        padding: 16px 24px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .page-header h4 {
            font-size: 1.3rem;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions a {
            flex: 1;
            justify-content: center;
        }

        .modern-table {
            font-size: 0.85rem;
        }

        .modern-table thead th {
            font-size: 0.75rem;
            padding: 10px 8px;
        }

        .modern-table tbody td {
            padding: 10px 8px;
        }
    }
</style>

<div class="container-fluid py-3">
    <!-- Page Header -->
    <div class="page-header">
        <h4>
            <i class="bi bi-speedometer2"></i>
            ໜ້າຫຼັກ
        </h4>
        <div class="header-actions">
            <a href="{{ route('teller.requests.create') }}" class="btn-create">
                <i class="bi bi-plus-circle"></i>
                ສ້າງຟອມໃໝ່
            </a>
            <a href="{{ route('teller.report') }}" class="btn-report">
                <i class="bi bi-graph-up"></i>
                ລາຍງານ
            </a>
        </div>
    </div>

    <!-- Pending Requests Table -->
    <div class="dashboard-card">
        <div class="card-header-custom">
            <div class="card-title">
                <i class="bi bi-clock-history"></i>
                ຟອມທີ່ລໍຖ້າດຳເນີນການ
            </div>
            <span class="card-badge">
                {{ $pending->total() }} ລາຍການ
            </span>
        </div>

        <div class="table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th width="60">No.</th>
                        <th>ລະຫັດອ້າງອີງ</th>
                        <th>ຊື່ຮ້ານຄ້າ</th>
                        <th>ສາຂາ</th>
                        <th>ວັນທີຕິດຕັ້ງ</th>
                        <th>ປະເພດທຸລະກິດ</th>
                        <th width="120" class="text-center">ສະຖານະ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $r)
                        <tr class="table-row-clickable" data-href="{{ route('teller.requests.show', $r->id) }}">
                            <td class="text-center fw-bold text-muted">{{ $r->id }}</td>
                            <td>
                                <span class="reference-code">
                                    <i class="bi bi-hash"></i>{{ $r->refer_code }}
                                </span>
                            </td>
                            <td>
                                <span class="store-name">
                                    <i class="bi bi-shop text-muted me-1"></i>
                                    {{ $r->store_name }}
                                </span>
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
                                <span class="status-badge">
                                    Pending
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>ບໍ່ມີຟອມທີ່ລໍຖ້າດຳເນີນການ</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pending->hasPages())
            <div class="pagination-wrapper">
                {{ $pending->links() }}
            </div>
        @endif
    </div>
</div>

{{-- ✅ ທຳໃຫ້ທັງແຖວຄລິກໄດ້ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.table-row-clickable').forEach(row => {
        row.addEventListener('click', () => {
            window.location.href = row.dataset.href;
        });
    });
});
</script>
@endsection
