@extends('layouts.admin')

@section('title', 'POS Registration Reports')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📊 Onboarding Summary Report</h4>

   <form method="GET" class="row mb-3">
    <div class="col-md-3">
        <label>Year</label>
        <select name="year" class="form-select" onchange="this.form.submit()">
            @foreach($years as $y)
                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label>Month</label>
        <select name="month" class="form-select" onchange="this.form.submit()">
            <option value="">All</option>
            @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                </option>
            @endfor
        </select>
    </div>

    <!-- ✅ เพิ่ม Filter สถานะ -->
    <div class="col-md-3">
        <label>Status</label>
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </div>

    <div class="col-md-3 text-end align-self-end">
        <a href="{{ route('admin.reports.export.excel', ['year'=>$year,'month'=>$month,'status'=>$status]) }}" class="btn btn-success">
    📊 Export Excel
</a>
<a href="{{ route('admin.reports.export.pdf', ['year'=>$year,'month'=>$month,'status'=>$status]) }}" class="btn btn-danger">
    🧾 Export PDF
</a>

    </div>
</form>


    <div class="card shadow-sm">
        <div class="card-header">📋 Summary of Onboarding Requests</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Refer ID</th>
                        <th>Teller ID</th> // add mai
                        <th>Store Name</th>

                        <th>Business Type</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->refer_code }}</td>
                            <td>{{ $r->teller_id }}</td>
                            <td>{{ $r->store_name }}</td>
                            <td>{{ $r->business_type }}</td>
                            <td>
                                <span class="badge
                                    @if($r->approval_status == 'approved') bg-success
                                    @elseif($r->approval_status == 'pending') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ ucfirst($r->approval_status) }}
                                </span>
                            </td>
                            <td>{{ $r->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.onboarding.show', $r->id) }}" class="btn btn-sm btn-primary">
                                    🔍 View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted">No records found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
