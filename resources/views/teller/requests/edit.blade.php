@extends('layouts.teller')

@section('title', 'Edit Onboarding Request')

@section('content')
<div class="container">
    <h4 class="mb-3">✏️ Edit Onboarding Request</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('teller.requests.update', $request->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Store Name</label>
            <input type="text" name="store_name" class="form-control" value="{{ old('store_name', $request->store_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Store Address</label>
            <input type="text" name="store_address" class="form-control" value="{{ old('store_address', $request->store_address) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Business Type</label>
            <input type="text" name="business_type" class="form-control" value="{{ old('business_type', $request->business_type) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">POS Serial</label>
            <input type="text" name="pos_serial" class="form-control" value="{{ old('pos_serial', $request->pos_serial) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Bank Account</label>
            <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account', $request->bank_account) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Installation Date</label>
            <input type="date" name="installation_date" class="form-control" value="{{ old('installation_date', $request->installation_date) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Branch</label>
            <select name="branch_id" class="form-select" required>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $request->branch_id == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Attachment</label>
            @if($request->attachment)
                <div class="mb-2">
                    <a href="{{ asset('storage/' . $request->attachment) }}" target="_blank">📎 View Current File</a>
                </div>
            @endif
            <input type="file" name="attachment" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">💾 Update</button>
        <a href="{{ route('teller.requests.show', $request->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
