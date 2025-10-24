@extends('layouts.teller')

@section('title', 'Create Onboarding Request')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📝 Create New Onboarding Request</h4>

    <form method="POST" action="{{ route('teller.requests.store') }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Store Name *</label>
                <input type="text" name="store_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Business Type *</label>
                <input type="text" name="business_type" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Store Address *</label>
            <textarea name="store_address" class="form-control" rows="2" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">POS Serial Number *</label>
                <input type="text" name="pos_serial" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Bank Account</label>
                <input type="text" name="bank_account" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Installation Date *</label>
                <input type="date" name="installation_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Branch *</label>
               <select name="branch_id" class="form-select" required>
    <option value="">-- Select Branch --</option>
    @foreach($branches as $branch)
        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
    @endforeach
</select>

            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Upload Attachment (PDF / JPG)</label>
            <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="text-end">
            <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">⬅ Back</a>
            <button type="submit" class="btn btn-primary">📤 Submit Request</button>
        </div>
    </form>
</div>
@endsection
