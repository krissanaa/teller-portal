@extends('layouts.admin')

@section('title', 'Onboarding Detail')

@section('content')
<div class="container">
    <h4 class="mb-3">🏪 Store Detail: {{ $req->store_name }}</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Refer Code:</strong> {{ $req->refer_code }}</p>
                    <p><strong>Teller ID:</strong> {{ $req->teller_id }}</p>
                    <p><strong>Branch ID:</strong> {{ $req->branch_id }}</p>
                    <p><strong>Business Type:</strong> {{ $req->business_type }}</p>
                    <p><strong>POS Serial:</strong> {{ $req->pos_serial }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Bank Account:</strong> {{ $req->bank_account }}</p>
                    <p><strong>Installation Date:</strong> {{ $req->installation_date }}</p>
                    <p><strong>Store Status:</strong> {{ $req->store_status }}</p>
                    <p><strong>Approval Status:</strong>
                        <span class="badge
                            @if($req->approval_status == 'approved') bg-success
                            @elseif($req->approval_status == 'pending') bg-warning text-dark
                            @else bg-danger @endif">
                            {{ ucfirst($req->approval_status) }}
                        </span>
                    </p>
                    <p><strong>Admin Remark:</strong> {{ $req->admin_remark ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <form action="{{ route('admin.onboarding.approve', $req->id) }}" method="POST">
            @csrf
            <button class="btn btn-success">✅ Approve</button>
        </form>
        <form action="{{ route('admin.onboarding.reject', $req->id) }}" method="POST">
            @csrf
            <button class="btn btn-danger">❌ Reject</button>
        </form>
        <a href="{{ route('admin.onboarding.index') }}" class="btn btn-secondary">⬅ Back</a>
    </div>
</div>
@endsection
