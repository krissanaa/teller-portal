@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📊 Admin Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total POS</h5>
                    <h2 class="fw-bold">{{ $total_pos }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Approved</h5>
                    <h2 class="fw-bold text-success">{{ $approved }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">Pending</h5>
                    <h2 class="fw-bold text-warning">{{ $pending }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0 border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Rejected</h5>
                    <h2 class="fw-bold text-danger">{{ $rejected }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
