@extends('layouts.teller')

@section('title', 'View Onboarding Details')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">📄 Onboarding Details</h4>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">{{ $request->store_name }}</h5>

            <p><strong>Refer Code:</strong> {{ $request->refer_code }}</p>
            <p><strong>Business Type:</strong> {{ $request->business_type }}</p>
            <p><strong>Address:</strong> {{ $request->store_address }}</p>
            <p><strong>POS Serial:</strong> {{ $request->pos_serial }}</p>
            <p><strong>Bank Account:</strong> {{ $request->bank_account ?? '-' }}</p>
            <p><strong>Installation Date:</strong> {{ $request->installation_date }}</p>
            <p><strong>Branch:</strong> {{ $request->branch->name ?? '-' }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge
                    @if($request->approval_status == 'approved') bg-success
                    @elseif($request->approval_status == 'pending') bg-warning text-dark
                    @else bg-danger @endif">
                    {{ ucfirst($request->approval_status) }}
                </span>
            </p>

            @if($request->attachment)
    <div class="mt-4">
        <h6>📎 Attached File</h6>
        @php
            $filePath = $request->attachment;
            $fileUrl = asset('storage/' . $filePath);
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        @endphp

        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
            <img src="{{ $fileUrl }}" alt="Attachment"
                 class="img-fluid mt-2 border rounded shadow-sm"
                 style="max-width: 500px;">
        @elseif($extension === 'pdf')
            <iframe src="{{ $fileUrl }}" width="100%" height="600px"
                    class="border rounded"></iframe>
            <p class="mt-2">
                <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    🔗 เปิดไฟล์ PDF เต็มจอ
                </a>
            </p>
        @else
            <p>ไม่สามารถแสดงไฟล์ประเภทนี้ได้
                <a href="{{ $fileUrl }}" target="_blank">ดาวน์โหลด</a>
            </p>
        @endif
    </div>
@endif

        </div>
    </div>


    @if($request->approval_status === 'pending')
    <a href="{{ route('teller.requests.edit', $request->id) }}" class="btn btn-warning me-2">✏️ Edit</a>
@endif
<a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">⬅ Back</a>

</div>
@endsection
