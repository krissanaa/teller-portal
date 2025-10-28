@extends('layouts.teller')

@section('title', 'Teller Dashboard')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">💼 Teller Dashboard</h4>
        <div>
            <a href="{{ route('teller.requests.create') }}" class="btn btn-success me-2">➕ สร้างฟอร์มใหม่</a>
            <a href="{{ route('teller.report') }}" class="btn btn-outline-primary">📊 รายงาน</a>
        </div>
    </div>

    {{-- 🕓 รายการ Pending --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-bold">
            ⏳ ฟอร์มที่รอดำเนินการ (Pending)
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>รหัสอ้างอิง</th>
                        <th>ชื่อร้านค้า</th>
                        <th>สาขา</th>
                        <th>วันที่ติดตั้ง</th>
                        <th>ประเภทธุรกิจ</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending as $r)
                        <tr class="table-row-clickable" data-href="{{ route('teller.requests.show', $r->id) }}">
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->refer_code }}</td>
                            <td class="fw-bold text-primary">{{ $r->store_name }}</td>
                            <td>{{ $r->branch?->name ?? '-' }}</td>
                            <td>{{ $r->installation_date }}</td>
                            <td>{{ $r->business_type }}</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <em>ไม่มีฟอร์มที่รอดำเนินการ</em>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $pending->links() }}</div>
        </div>
    </div>
</div>

{{-- ✅ ทำให้ทั้งแถวคลิกได้ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.table-row-clickable').forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', () => {
            window.location.href = row.dataset.href;
        });
    });
});
</script>

<style>
.table-row-clickable:hover {
    background-color: #f0f6ff !important;
    transition: background-color 0.2s ease-in-out;
}
</style>
@endsection
