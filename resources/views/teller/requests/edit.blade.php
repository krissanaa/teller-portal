@extends('layouts.teller')

@section('title', 'ແກ້ໄຂຄຳຂໍເປີດບັນຊີ')

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
        border-left: 4px solid #ffc107;
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

    .page-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 6px;
        margin-bottom: 0;
    }

    .alert-custom {
        border-radius: 10px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .alert-custom i {
        font-size: 1.3rem;
    }

    .warning-box {
        background: #fff3cd;
        border-left: 3px solid #ffc107;
        padding: 14px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        display: flex;
        align-items: start;
        gap: 12px;
    }

    .warning-box i {
        color: #ffc107;
        font-size: 1.3rem;
        margin-top: 2px;
    }

    .warning-box-content {
        flex: 1;
    }

    .warning-box-title {
        color: #000;
        font-weight: 700;
        margin-bottom: 4px;
        font-size: 0.95rem;
    }

    .warning-box-text {
        color: #856404;
        font-size: 0.85rem;
        margin: 0;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .form-body {
        padding: 30px;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        color: #212529;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--apb-accent);
        font-size: 1.2rem;
    }

    .form-label {
        font-weight: 600;
        color: #212529;
        margin-bottom: 6px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label i {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .required {
        color: #dc3545;
        font-weight: 700;
    }

    .form-control, .form-select {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 11px 14px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--apb-accent);
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.15);
        background: white;
    }

    .form-control:hover, .form-select:hover {
        border-color: #adb5bd;
    }

    .help-text {
        background: #f8f9fa;
        border-left: 3px solid var(--apb-accent);
        padding: 14px 16px;
        border-radius: 6px;
        margin-bottom: 24px;
        font-size: 0.9rem;
    }

    .help-text i {
        color: var(--apb-accent);
        margin-right: 6px;
    }

    .current-file-box {
        background: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 12px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #212529;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .current-file-box:hover {
        background: #e9ecef;
        color: #212529;
    }

    .current-file-box i {
        font-size: 1.1rem;
        color: var(--apb-accent);
    }
 /* Drag & Drop File Upload Area */
    .file-upload-container {
        margin-bottom: 20px;
    }

    .file-upload-area {
        border: 3px dashed #B0BEC5;
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        background: #FAFAFA;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .file-upload-area:hover {
        border-color: var(--apb-accent);
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
    }

    .file-upload-area.dragover {
        border-color: var(--apb-accent);
        background: var(--apb-light);
        transform: scale(1.02);
    }

    .file-upload-icon {
        font-size: 3.5rem;
        color: var(--apb-accent);
        margin-bottom: 16px;
        display: block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .file-upload-text {
        color: var(--apb-primary);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .file-upload-hint {
        color: #78909C;
        font-size: 0.9rem;
        margin-bottom: 12px;
    }

    .file-upload-formats {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 16px;
    }

    .format-badge {
        background: white;
        border: 2px solid #E0E0E0;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #546E7A;
    }

    #fileName {
        margin-top: 12px;
        color: var(--apb-accent);
        font-weight: 700;
    }

    .form-actions {
        padding: 20px 30px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-update {
        background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
        border: none;
        color: white;
        padding: 11px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 95, 63, 0.3);
        background: linear-gradient(90deg, var(--apb-secondary) 0%, var(--apb-dark) 100%);
        color: white;
    }

    .btn-cancel {
        background: rgb(255, 255, 255);
        border: 2px solid #f70000;
        color: #000000;
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-size: 1rem;
    }

    .btn-cancel:hover {
        background: rgb(255, 0, 0);
        border: 2px solid #ff0000;
        color: #ffffff;
        transform: translateY(-3px);
    }
    @media (max-width: 768px) {
        .form-body, .form-actions {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions button, .form-actions a {
            width: 100%;
            justify-content: center;
        }
    }
    .file-upload-container {
        margin-bottom: 20px;
    }

    .file-upload-area {
        border: 3px dashed #B0BEC5;
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        background: #FAFAFA;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .file-upload-area:hover {
        border-color: var(--apb-accent);
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);
    }

    .file-upload-area.dragover {
        border-color: var(--apb-accent);
        background: var(--apb-light);
        transform: scale(1.02);
    }
     .format-badge {
        background: white;
        border: 2px solid #E0E0E0;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #546E7A;
    }
    .file-upload-text {
        color: var(--apb-primary);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .file-upload-hint {
        color: #78909C;
        font-size: 0.9rem;
        margin-bottom: 12px;
    }

    .file-upload-formats {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 16px;
    }

    .format-badge {
        background: white;
        border: 2px solid #E0E0E0;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #546E7A;
    }

    /* File List */
    .file-list {
        margin-top: 20px;
    }

    .file-item {
        background: white;
        border: 2px solid #E0E0E0;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .file-item:hover {
        border-color: var(--apb-accent);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        background: var(--apb-light);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--apb-accent);
        font-size: 1.3rem;
    }

    .file-details {
        flex: 1;
    }

    .file-name {
        font-weight: 600;
        color: #212529;
        margin-bottom: 2px;
        font-size: 0.9rem;
    }

    .file-size {
        color: #78909C;
        font-size: 0.8rem;
    }

    .file-remove {
        background: #FFEBEE;
        border: 2px solid #FFCDD2;
        color: #C62828;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .file-remove:hover {
        background: #EF5350;
        color: white;
        transform: scale(1.1);
    }
    /* Attachment Section */
    .attachment-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border: 2px dashed #ced4da;
        margin-top: 20px;
    }

    .attachment-header {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #212529;
        font-weight: 700;
        font-size: 1.05rem;
        margin-bottom: 14px;
    }

    .attachment-header i {
        color: var(--apb-accent);
    }

    .attachment-preview {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 14px;
    }

    .attachment-preview img {
        max-width: 100%;
        height: auto;
        display: block;
        border-radius: 10px;
    }

    .pdf-viewer {
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }

    /* Action Buttons */
    .action-buttons {
        padding: 20px 28px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-edit {
        background: #ffc107;
        border: none;
        color: #000;
        padding: 11px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-edit:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        color: #000;
    }



    .btn-pdf {
        background: linear-gradient(90deg, var(--apb-primary) 0%, var(--apb-secondary) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 95, 63, 0.3);
        color: white;
    }

    @media (max-width: 768px) {
        .detail-row {
            flex-direction: column;
            gap: 6px;
        }

        .detail-label {
            flex: none;
        }

        .card-body-custom, .action-buttons {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons > * {
            width: 100%;
            justify-content: center;
        }
    }
    .drive-style-section {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid #e9ecef;
}
.drive-header {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #2D5F3F;
    font-size: 1.1rem;
}
.drive-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
}
.drive-card {
    position: relative;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    overflow: hidden;
    cursor: pointer;
    transition: all 0.25s ease;
}
.drive-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 14px rgba(0,0,0,0.12);
}
.drive-thumb {
    height: 160px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}
.drive-thumb img,
.drive-thumb iframe {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: none;
}
.drive-type {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255,255,255,0.8);
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 0.85rem;
    font-weight: bold;
}
.drive-type.pdf { color: #dc3545; }
.drive-icon i {
    font-size: 3rem;
    color: #adb5bd;
}
.drive-name {
    padding: 10px 12px;
    font-size: 0.9rem;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: center;
}
.modal-xl {
    max-width: 98vw !important;
}
#previewModal .modal-content {
    height: 96vh;
    border-radius: 12px;
    overflow: hidden;
}
#previewModal .modal-body {
    padding: 0;
    height: calc(100vh - 80px);
}

</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h4>
            <i class="bi bi-pencil-square"></i>
            ແກ້ໄຂຄຳຂໍເປີດບັນຊີ
        </h4>
        <p class="page-subtitle">ແກ້ໄຂຂໍ້ມູນຮ້ານຄ້າ ແລະ ປັບປຸງລາຍລະອຽດ</p>
    </div>

    <!-- Error Message -->
    @if(session('error'))
        <div class="alert-custom alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Warning Box -->
    <div class="warning-box">
        <i class="bi bi-info-circle-fill"></i>
        <div class="warning-box-content">
            <div class="warning-box-title">ຂໍ້ມູນສຳຄັນ</div>
            <p class="warning-box-text">ທ່ານສາມາດແກ້ໄຂຂໍ້ມູນໄດ້ເມື່ອສະຖານະຍັງເປັນ "ລໍຖ້າອະນຸມັດ" ເທົ່ານັ້ນ</p>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="form-card">
        <form method="POST" action="{{ route('teller.requests.update', $request->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-body">
                <!-- Help Text -->
                <div class="help-text">
                    <i class="bi bi-lightbulb-fill"></i>
                    <strong>ໝາຍເຫດ:</strong> ກະລຸນາກວດສອບຂໍ້ມູນໃຫ້ຖືກຕ້ອງກ່ອນບັນທຶກ. ຊ່ອງທີ່ມີເຄື່ອງໝາຍ <span class="required">*</span> ແມ່ນຈຳເປັນ
                </div>

                <!-- Section 1: Store Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-shop"></i>
                        ຂໍ້ມູນຮ້ານຄ້າ
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-building"></i>
                                ຊື່ຮ້ານຄ້າ <span class="required">*</span>
                            </label>
                            <input type="text" name="store_name" class="form-control"
                                   value="{{ old('store_name', $request->store_name) }}"
                                   required placeholder="ປ້ອນຊື່ຮ້ານຄ້າ">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-briefcase"></i>
                                ປະເພດທຸລະກິດ <span class="required">*</span>
                            </label>
                            <input type="text" name="business_type" class="form-control"
                                   value="{{ old('business_type', $request->business_type) }}"
                                   required placeholder="ເຊັ່ນ: ຮ້ານອາຫານ, ຮ້ານຂາຍເຄື່ອງ">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-geo-alt"></i>
                            ທີ່ຢູ່ຮ້ານຄ້າ <span class="required">*</span>
                        </label>
                        <textarea name="store_address" class="form-control" rows="3"
                                  required placeholder="ປ້ອນທີ່ຢູ່ຮ້ານຄ້າແບບລະອຽດ">{{ old('store_address', $request->store_address) }}</textarea>
                    </div>
                </div>

                <!-- Section 2: POS & Banking -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-credit-card"></i>
                        ຂໍ້ມູນ POS ແລະ ທະນາຄານ
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-upc-scan"></i>
                                ໝາຍເລກເຄື່ອງ POS <span class="required">*</span>
                            </label>
                            <input type="text" name="pos_serial" class="form-control"
                                   value="{{ old('pos_serial', $request->pos_serial) }}"
                                   required placeholder="ເຊັ່ນ: POS-2024-001">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-bank"></i>
                                ເລກບັນຊີທະນາຄານ <span class="required">*</span>
                            </label>
                            <input type="text" name="bank_account" class="form-control"
                                   value="{{ old('bank_account', $request->bank_account) }}"
                                   required placeholder="ປ້ອນເລກບັນຊີ">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Installation Details -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-calendar-check"></i>
                        ຂໍ້ມູນການຕິດຕັ້ງ
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-calendar3"></i>
                                ວັນທີຕິດຕັ້ງ <span class="required">*</span>
                            </label>
                            <input type="date" name="installation_date" class="form-control"
                                   value="{{ old('installation_date', $request->installation_date) }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-pin-map"></i>
                                ສາຂາ <span class="required">*</span>
                            </label>
                            <select name="branch_id" class="form-select" required>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                            {{ old('branch_id', $request->branch_id) == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
<!-- Section 4: Multiple File Upload with Drag & Drop -->
<div class="form-section">
    <div class="section-title">
        <i class="bi bi-paperclip"></i>
        ເອກະສານແນບ
    </div>

    @php
        $attachments = json_decode($request->attachments ?? '[]', true);
    @endphp

    <!-- Existing Attachments -->
    @if(!empty($attachments))
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-folder-fill"></i> ຟາຍທີ່ມີຢູ່ (ເລືອກຟາຍທີ່ທີ່ຕ້ອງການລົບ ແລະ ເພີ່ມຟາຍໃໝ່ກ່ອນບັນທຶກ)
            </label>

            <div class="row g-3">
                @foreach($attachments as $index => $filePath)
                    @php
                        $fileUrl = asset('storage/' . $filePath);
                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        $fileName = basename($filePath);
                    @endphp

                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-sm h-100 text-center p-2 position-relative drive-card">
                            <div class="position-relative drive-thumb"
                                 onclick="openPreview('{{ $fileUrl }}','{{ $fileName }}','{{ $extension }}')">
                                @if(in_array($extension, ['jpg','jpeg','png']))
                                    <img src="{{ $fileUrl }}" alt="{{ $fileName }}"
                                         class="img-fluid w-100 h-100" style="object-fit:cover;">
                                @elseif($extension === 'pdf')
                                    <iframe src="{{ $fileUrl }}" title="{{ $fileName }}"></iframe>
                                @else
                                    <div class="d-flex flex-column justify-content-center align-items-center bg-light h-100">
                                        <i class="bi bi-file-earmark fs-1 text-secondary"></i>
                                        <small>{{ strtoupper($extension) }}</small>
                                    </div>
                                @endif
                                <span class="drive-type">{{ strtoupper($extension) }}</span>
                            </div>
                            <div class="mt-2 small text-truncate">{{ $fileName }}</div>

                            <!-- Delete checkbox -->
                            <div class="text-center mt-1">
                                <label class="form-check-label text-danger small" style="cursor:pointer;">
                                    <input type="checkbox" name="delete_attachments[]" value="{{ $index }}" class="form-check-input me-1">
                                    ລົບຟາຍນີ້
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 📂 Drag & Drop Upload Area -->
    <div class="mb-3">
        <label class="form-label">
            <i class="bi bi-cloud-upload"></i>
            ອັບໂຫລດຟາຍໃໝ່
        </label>

        <div id="dropArea" class="file-upload-area">
            <input type="file" name="attachments[]" id="fileInput" multiple class="d-none" accept=".pdf,.jpg,.jpeg,.png">
            <div>
                <i class="bi bi-cloud-arrow-up file-upload-icon"></i>
                <div class="file-upload-text">ລາກຟາຍມາວາງທີ່ນີ້ ຫຼື ຄລິກເພື່ອເລືອກ</div>
                <div class="file-upload-hint">ສາມາດອັບໂຫລດຫຼາຍຟາຍພ້ອມກັນ (ແຕ່ລະຟາຍສູງສຸດ 5MB)</div>
                  <div class="file-upload-formats">
                                <span class="format-badge">📄 PDF</span>
                                <span class="format-badge">🖼️ JPG</span>
                                <span class="format-badge">🖼️ PNG</span>
                            </div>
            </div>
        </div>

        <div class="file-list" id="fileList"></div>
    </div>
</div>

<!-- 🔍 Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewTitle" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen"> <!-- 👈 ใช้ fullscreen modal -->
        <div class="modal-content bg-dark text-white border-0">
            <div class="modal-header border-0 bg-success py-2">
                <h5 class="modal-title text-white" id="previewTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" id="previewContainer">
                <!-- Preview will load dynamically -->
            </div>
        </div>
    </div>
</div>


            <!-- Action Buttons -->
            <div class="form-actions">
                <a href="{{ route('teller.requests.show', $request->id) }}" class="btn-cancel">
                    <i class="bi bi-x-circle"></i>
                    ຍົກເລີກ
                </a>
                <button type="submit" class="btn-update">
                    <i class="bi bi-check-circle-fill"></i>
                    ບັນທຶກການແກ້ໄຂ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Multiple file upload with drag & drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    let selectedFiles = [];

    // Click to select files
    dropArea.addEventListener('click', () => fileInput.click());

    // File input change
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag & Drop Events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.classList.add('dragover');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.classList.remove('dragover');
        }, false);
    });

    dropArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }, false);

    // Handle files
    function handleFiles(files) {
        const validFiles = [...files].filter(file => {
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!validTypes.includes(file.type)) {
                alert(`ໄຟລ໌ ${file.name} ບໍ່ຖືກຕ້ອງ. ກະລຸນາເລືອກ PDF, JPG, ຫຼື PNG ເທົ່ານັ້ນ.`);
                return false;
            }

            if (file.size > maxSize) {
                alert(`ໄຟລ໌ ${file.name} ມີຂະໜາດໃຫຍ່ເກີນ 5MB.`);
                return false;
            }

            return true;
        });

        validFiles.forEach(file => {
            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
            }
        });

        updateFileList();
        updateFileInput();
    }

    // Update file list display
    function updateFileList() {
        fileList.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            fileItem.innerHTML = `
                <div class="file-info">
                    <div class="file-icon">
                        <i class="bi bi-${getFileIcon(file.type)}"></i>
                    </div>
                    <div class="file-details">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                </div>
                <button type="button" class="file-remove" onclick="removeFile(${index})">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;
            fileList.appendChild(fileItem);
        });
    }

    // Update hidden file input
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // Remove file
    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updateFileList();
        updateFileInput();
    };

    // Get file icon
    function getFileIcon(type) {
        if (type === 'application/pdf') return 'file-pdf-fill';
        if (type.startsWith('image/')) return 'file-image-fill';
        return 'file-earmark-fill';
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
});
function openPreview(fileUrl, fileName, extension) {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    const title = document.getElementById('previewTitle');
    const container = document.getElementById('previewContainer');

    title.textContent = fileName;
    container.innerHTML = '';

    if (['jpg', 'jpeg', 'png'].includes(extension)) {
        container.innerHTML = `
            <div class="d-flex justify-content-center align-items-center bg-black" style="height:100vh;">
                <img src="${fileUrl}" class="img-fluid rounded shadow">
            </div>`;
    }
    else if (extension === 'pdf') {
        container.innerHTML = `
            <iframe src="${fileUrl}"
                width="100%"
                height="100%"
                style="border:0; display:block;"
                class="bg-dark">
            </iframe>`;
    }
    else {
        container.innerHTML = `
            <div class="d-flex flex-column justify-content-center align-items-center text-center text-white-50" style="height:100vh;">
                <i class="bi bi-file-earmark fs-1"></i>
                <p class="mt-3">ບໍ່ສາມາດເບິ່ງຟາຍນີ້ໄດ້<br>
                <a href="${fileUrl}" target="_blank" class="text-success fw-bold">ດາວໂຫລດ</a></p>
            </div>`;
    }

    modal.show();
}
</script>
@endsection
