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

    .file-upload-area {
        border: 2px dashed #ced4da;
        border-radius: 10px;
        padding: 30px 20px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: var(--apb-accent);
        background: white;
    }

    .file-upload-area i {
        font-size: 3rem;
        color: var(--apb-accent);
        margin-bottom: 12px;
    }

    .file-upload-text {
        color: #212529;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .file-upload-hint {
        color: #6c757d;
        font-size: 0.85rem;
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
        background: white;
        border: 1px solid #ced4da;
        color: #212529;
        padding: 11px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #212529;
        transform: translateY(-2px);
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

                <!-- Section 4: Attachment -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="bi bi-paperclip"></i>
                        ເອກະສານແນບ
                    </div>

                    @if($request->attachments)
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-file-check"></i>
                                ໄຟລ໌ປັດຈຸບັນ
                            </label>
                            <div>
                                <a href="{{ asset('storage/' . $request->attachments) }}"
                                   target="_blank"
                                   class="current-file-box">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    ເບິ່ງໄຟລ໌ທີ່ອັບໂຫລດແລ້ວ
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-cloud-upload"></i>
                            ອັບໂຫລດໄຟລ໌ໃໝ່ (ຖ້າຕ້ອງການປ່ຽນ)
                        </label>
                        <label for="attachments" class="file-upload-area">
                            <input type="file" name="attachments" id="attachments"
                                   class="d-none" accept=".pdf,.jpg,.jpeg,.png"
                                   onchange="updateFileName(this)">
                            <div>
                                <i class="bi bi-cloud-arrow-up"></i>
                                <div class="file-upload-text">ຄລິກເພື່ອອັບໂຫລດເອກະສານໃໝ່</div>
                                <div class="file-upload-hint">ຮອງຮັບໄຟລ໌: PDF, JPG, PNG (ສູງສຸດ 5MB)</div>
                                <div id="fileName"></div>
                            </div>
                        </label>
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
function updateFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        fileName.textContent = '✓ ' + input.files[0].name;
        fileName.style.color = 'var(--apb-accent)';
        fileName.style.fontWeight = '700';
    } else {
        fileName.textContent = '';
    }
}
</script>
@endsection
