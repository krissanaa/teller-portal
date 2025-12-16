@extends('layouts.teller')

@section('title', 'ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ')

@section('content')
@php
$tellerProfile = $tellerProfile ?? auth()->user()->loadMissing(['branch', 'unit']);
@endphp
<div class="container-fluid">
    <h4 class="mb-3">👁️ ລາຍລະອຽດຄຳຂໍເປີດບັນຊີ</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="mb-3">{{ $request->store_name }}</h5>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>ຊື່ຮ້ານຄ້າ:</strong> {{ $request->store_name }}</p>
                    <p><strong>ປະເພດທຸລະກິດ:</strong> {{ $request->business_type }}</p>
                    <p><strong>ເລກບັນຊີທະນາຄານ:</strong> {{ $request->bank_account ?? '-' }}</p>
                    <p><strong>ວັນທີຕິດຕັ້ງ:</strong> {{ \Carbon\Carbon::parse($request->installation_date)->format('d/m/Y') }}</p>
                    <p><strong>ສະຖານະ:</strong>
                        @if($request->approval_status == 'approved')
                        <span class="badge bg-success">ອະນຸມັດ</span>
                        @elseif($request->approval_status == 'pending')
                        <span class="badge bg-warning text-dark">ລໍຖ້າອະນຸມັດ</span>
                        @else
                        <span class="badge bg-danger">ປະຕິເສດ</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>ທີ່ຢູ່ຮ້ານຄ້າ:</strong> {{ $request->store_address }}</p>
                    <p><strong>ລະຫັດອ້າງອີງ:</strong> {{ $request->refer_code }}</p>
                    <p><strong>ລະຫັດເຄື່ອງ POS:</strong> {{ $request->pos_serial ?? '-' }}</p>
                </div>
            </div>

            @if(!empty($request->attachments))
            <hr>
            <h6 class="fw-bold mb-3">ເອກະສານແນບ</h6>
            <div class="d-flex flex-wrap gap-2">
                @php $attachments = json_decode($request->attachments ?? '[]', true); @endphp
                @foreach($attachments as $filePath)
                @php
                $fileUrl = asset('storage/' . $filePath);
                $fileName = basename($filePath);
                $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                @endphp
                <div class="card p-2 shadow-sm d-flex align-items-center gap-2" style="cursor: pointer; width: 200px;"
                    onclick="openPreview('{{ $fileUrl }}', '{{ $fileName }}', '{{ $extension }}')">
                    <div class="fs-2 text-secondary">
                        @if(in_array($extension, ['jpg','jpeg','png']))
                        <i class="bi bi-file-image"></i>
                        @elseif($extension === 'pdf')
                        <i class="bi bi-file-pdf text-danger"></i>
                        @else
                        <i class="bi bi-file-earmark"></i>
                        @endif
                    </div>
                    <div class="text-truncate" style="flex: 1;">
                        <span class="d-block small fw-bold text-truncate" title="{{ $fileName }}">{{ $fileName }}</span>
                        <span class="d-block small text-muted">{{ strtoupper($extension) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if($request->admin_remark)
            <div class="alert alert-danger mt-3">
                <strong>ໝາຍເຫດຈາກຜູ້ອະນຸມັດ:</strong> {{ $request->admin_remark }}
            </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('teller.requests.edit', $request->id) }}" class="btn btn-warning">✏️ ແກ້ໄຂຂໍ້ມູນ</a>
        <a href="{{ route('teller.dashboard') }}" class="btn btn-secondary">⬅️ ກັບຄືນ</a>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="height: 85vh; border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom-0 py-3 px-4" style="background: white; position: absolute; top: 0; left: 0; right: 0; z-index: 10;">
                <h5 class="modal-title text-dark fw-bold" id="previewTitle" style="font-size: 1.1rem;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="background-color: #f1f5f9; padding: 10px; border-radius: 50%; opacity: 1;"></button>
            </div>
            <div class="modal-body p-0 bg-light d-flex align-items-center justify-content-center" id="previewContainer" style="padding-top: 60px !important;"></div>
        </div>
    </div>
</div>

<script>
    function openPreview(fileUrl, fileName, extension) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        document.getElementById('previewTitle').textContent = fileName;
        const container = document.getElementById('previewContainer');
        container.innerHTML = '';

        if (['jpg', 'jpeg', 'png'].includes(extension)) {
            container.innerHTML = `<img src="${fileUrl}" class="img-fluid shadow-sm" style="max-height: 100%; max-width: 100%; border-radius: 8px;">`;
        } else if (extension === 'pdf') {
            container.innerHTML = `<iframe src="${fileUrl}" width="100%" height="100%" style="border:0;"></iframe>`;
        } else {
            container.innerHTML = `
                <div class="text-center">
                    <div class="mb-3"><i class="bi bi-file-earmark-text text-secondary" style="font-size: 4rem;"></i></div>
                    <h5 class="text-secondary mb-3">ບໍ່ສາມາດສະແດງຕົວຢ່າງໄດ້</h5>
                    <a href="${fileUrl}" class="btn btn-primary px-4 rounded-pill" download>
                        <i class="bi bi-download me-2"></i> ດາວໂຫລດໄຟລ໌
                    </a>
                </div>`;
        }
        modal.show();
    }
</script>
@endsection