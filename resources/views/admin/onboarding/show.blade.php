@extends('layouts.admin')

@section('title', 'Onboarding Detail')

@section('content')
@php
    use Illuminate\Support\Str;

    $chips = [
        ['label' => 'Teller ID', 'value' => optional($req->teller)->name ? optional($req->teller)->name .' ('. $req->teller_id .')' : ($req->teller_id ?? '-') , 'icon' => 'bi-person-badge'],
        ['label' => 'Refer ID', 'value' => $req->refer_code ?? '-', 'icon' => 'bi-upc'],
        ['label' => 'Branch', 'value' => optional($req->branch)->name ?? '-', 'icon' => 'bi-diagram-3'],
        ['label' => 'Business Type', 'value' => $req->business_type ?? '-', 'icon' => 'bi-briefcase'],
        ['label' => 'POS Serial', 'value' => $req->pos_serial ?? '-', 'icon' => 'bi-cpu'],
        ['label' => 'Bank Account', 'value' => $req->bank_account ?? '-', 'icon' => 'bi-bank'],
    ];

    $attachments = is_array($req->attachments)
        ? $req->attachments
        : (is_string($req->attachments) ? json_decode($req->attachments ?? '[]', true) : []);
@endphp

<style>
    :root {
        --card-bg: #ffffff;
        --card-border: rgba(28, 114, 75, 0.18);
        --chip-bg: rgba(28, 114, 75, 0.08);
        --chip-border: rgba(28, 114, 75, 0.2);
        --text-dark: #0f172a;
        --text-muted: #6b7280;
        --status-approved: #1c724b;
        --status-pending: #d97706;
        --status-rejected: #b91c1c;
    }

    .detail-shell {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1rem 3rem;
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
    }

    .detail-card {
        border-radius: 24px;
        border: 1px solid var(--card-border);
        background: var(--card-bg);
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.12);
        padding: 2rem;
        position: relative;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .detail-header h1 {
        margin: 0;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 800;
        color: #0f172a;
    }

    .detail-header p {
        margin: 0.3rem 0 0;
        color: var(--text-muted);
    }

    .status-pill {
        align-self: flex-start;
        border-radius: 999px;
        padding: 0.4rem 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.78rem;
    }

    .status-pill.approved { background: rgba(22, 163, 74, 0.15); color: #15803d; }
    .status-pill.pending { background: rgba(252, 211, 77, 0.25); color: #92400e; }
    .status-pill.rejected { background: rgba(248, 113, 113, 0.2); color: #b91c1c; }

    .chip-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 0.9rem;
        margin-bottom: 1.25rem;
    }

    .info-chip {
        border: 1px solid var(--chip-border);
        border-radius: 16px;
        background: var(--chip-bg);
        padding: 0.85rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
    }

    .info-chip i {
        color: var(--status-approved);
        font-size: 1.1rem;
        margin-top: 0.1rem;
    }

    .info-chip strong {
        display: block;
        font-size: 0.9rem;
        color: #0f172a;
    }

    .info-chip span {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .tag-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .tag-row span {
        background: rgba(28, 114, 75, 0.12);
        border-radius: 999px;
        padding: 0.35rem 0.9rem;
        font-size: 0.78rem;
        color: var(--status-approved);
        font-weight: 600;
    }

    .attachment-area {
        border: 1px dashed rgba(79, 70, 229, 0.35);
        border-radius: 20px;
        padding: 1rem;
        background: rgba(79, 70, 229, 0.03);
        margin-bottom: 1.25rem;
    }

    .attachment-card {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        border: 1px solid rgba(28, 114, 75, 0.2);
        border-radius: 16px;
        padding: 0.6rem 0.8rem;
        background: #fff;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
        text-decoration: none;
        color: inherit;
        transition: transform 0.15s ease;
    }

    .attachment-card:hover {
        transform: translateY(-2px);
    }

    .attachment-thumb {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        overflow: hidden;
        background: rgba(148, 163, 184, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .attachment-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .attachment-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(5, 12, 9, 0.92);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        z-index: 1050;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }

    .attachment-lightbox.show {
        opacity: 1;
        pointer-events: all;
    }

    .lightbox-content {
        position: relative;
        width: min(90vw, 1000px);
        max-height: 92vh;
        background: #0f1a15;
        border-radius: 18px;
        border: 1px solid rgba(28, 114, 75, 0.3);
        overflow: hidden;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
    }

    .lightbox-body {
        padding: 1rem;
        background: #0f1a15;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-body.scrollable {
        overflow: auto;
    }

    .lightbox-body img,
    .lightbox-body iframe {
        width: clamp(300px, 100%, 900px);
        max-height: 85vh;
        object-fit: contain;
        border: none;
        border-radius: 12px;
        background: #fff;
    }

    .lightbox-body.scrollable iframe {
        height: 85vh;
        max-height: none;
    }

    .lightbox-close {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 1.1rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
    }

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .detail-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-top: 1.25rem;
    }
</style>

<div class="detail-shell">
    <div class="detail-card">
        <div class="detail-header">
            <div>
                <span class="status-pill {{ $req->approval_status }}">{{ ucfirst($req->approval_status) }}</span>
                <h1>{{ $req->store_name ?? 'Unnamed Store' }}</h1>
                @if($req->store_address)
                    <p><i class="bi bi-geo-alt"></i> {{ Str::limit($req->store_address, 120) }}</p>
                @endif
            </div>
            <div class="text-muted small">
                @if($req->created_at)
                    <p class="mb-0"><i class="bi bi-calendar-event"></i> Submitted {{ $req->created_at->format('M d, Y \\a\\t h:i A') }}</p>
                @endif
                <p class="mb-0"><strong>Attachments:</strong> {{ count($attachments) }}</p>
            </div>
        </div>

        <div class="chip-grid">
            @foreach($chips as $chip)
                <div class="info-chip">
                    <i class="bi {{ $chip['icon'] }}"></i>
                    <div>
                        <strong>{{ $chip['label'] }}</strong>
                        <span>{{ $chip['value'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chip-grid">
            <div class="info-chip">
                <i class="bi bi-calendar-check"></i>
                <div>
                    <strong>Installation Date</strong>
                    <span>{{ $req->installation_date ? \Carbon\Carbon::parse($req->installation_date)->format('M d, Y') : '-' }}</span>
                </div>
            </div>
            <div class="info-chip">
                <i class="bi bi-info-circle"></i>
                <div>
                    <strong>Store Status</strong>
                    <span>{{ Str::title(str_replace('_', ' ', $req->store_status ?? 'Unknown')) }}</span>
                </div>
            </div>
            <div class="info-chip">
                <i class="bi bi-chat-text"></i>
                <div>
                    <strong>Admin Remark</strong>
                    <span>{{ $req->admin_remark ?? '—' }}</span>
                </div>
            </div>
        </div>

        <div class="tag-row">
            <span><i class="bi bi-person-circle"></i> Teller ID: {{ $req->teller_id ?? 'N/A' }}</span>
            <span><i class="bi bi-upc-scan"></i> Refer: {{ $req->refer_code ?? 'N/A' }}</span>
        </div>

        @if(count($attachments))
            <div class="attachment-area">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Attachments</h6>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($attachments as $filePath)
                        @php
                            $fileUrl = asset('storage/' . ltrim($filePath, '/'));
                            $fileName = basename($filePath);
                            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        @endphp
                        <button type="button"
                            class="attachment-card btn p-0"
                            onclick="openAdminPreview('{{ $fileUrl }}', '{{ addslashes($fileName) }}', '{{ $extension }}')">
                            <div class="attachment-thumb">
                                @if(in_array($extension, ['jpg','jpeg','png','gif']))
                                    <img src="{{ $fileUrl }}" alt="{{ $fileName }}">
                                @elseif($extension === 'pdf')
                                    <span class="fw-bold text-danger">PDF</span>
                                @else
                                    <i class="bi bi-paperclip fs-4 text-success"></i>
                                @endif
                            </div>
                            <div class="text-start">
                                <div class="fw-semibold">{{ Str::limit($fileName, 20) }}</div>
                                <small class="text-muted">Click to preview</small>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="detail-actions">
            <a href="{{ route('admin.onboarding.index') }}" class="btn btn-outline-secondary">
                Back to requests
            </a>
            @if($req->approval_status === 'pending')
                <form action="{{ route('admin.onboarding.approve', $req->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success" type="submit">Approve</button>
                </form>
                <button class="btn btn-danger" type="button" id="openRejectModal" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    Reject
                </button>
            @endif
        </div>
    </div>
</div>
<div id="attachmentLightbox" class="attachment-lightbox d-none">
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeAdminPreview()">&times;</button>
        <div class="lightbox-body" id="lightboxBody"></div>
    </div>
</div>

<!-- Reject Confirmation Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="bi bi-x-octagon me-2"></i> Reject Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.onboarding.reject', $req->id) }}">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3">Please tell the teller why this request is rejected.</p>
                    <label for="modal_admin_remark" class="form-label fw-semibold text-danger small">
                        Reject remark
                    </label>
                    <textarea
                        name="admin_remark"
                        id="modal_admin_remark"
                        class="form-control @error('admin_remark') is-invalid @enderror"
                        rows="3"
                        required
                        placeholder="Example: Missing POS serial or incorrect bank account">{{ old('admin_remark') }}</textarea>
                    @error('admin_remark')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->has('admin_remark'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
            rejectModal.show();
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggerRejectBtn = document.getElementById('openRejectModal');
        const rejectModalEl = document.getElementById('rejectModal');

        if (triggerRejectBtn && rejectModalEl && window.bootstrap) {
            const rejectModal = new bootstrap.Modal(rejectModalEl);
            triggerRejectBtn.addEventListener('click', function (event) {
                event.preventDefault();
                rejectModal.show();
            });
        }
    });
</script>

<script>
    function openAdminPreview(fileUrl, fileName, extension) {
        const overlay = document.getElementById('attachmentLightbox');
        const body = document.getElementById('lightboxBody');

        extension = (extension || '').toLowerCase();
        body.innerHTML = '';
        body.classList.remove('scrollable');

        if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
            body.innerHTML = `<img src="${fileUrl}" alt="${fileName ?? ''}">`;
        } else if (extension === 'pdf') {
            body.classList.add('scrollable');
            body.innerHTML = `<iframe src="${fileUrl}" width="100%" style="border:0;"></iframe>`;
        } else {
            body.innerHTML = `<div class="text-center text-light">
                <p class="mb-3">Preview not supported. Download to view this file.</p>
                <a href="${fileUrl}" class="btn btn-primary" target="_blank" rel="noopener">
                    <i class="bi bi-download"></i> Download ${fileName ?? ''}
                </a>
            </div>`;
        }

        overlay.classList.remove('d-none');
        setTimeout(() => overlay.classList.add('show'), 10);
        document.body.classList.add('modal-open');
    }

    function closeAdminPreview() {
        const overlay = document.getElementById('attachmentLightbox');
        overlay.classList.remove('show');
        document.body.classList.remove('modal-open');
        setTimeout(() => overlay.classList.add('d-none'), 200);
    }

    document.addEventListener('click', (event) => {
        const overlay = document.getElementById('attachmentLightbox');
        if (overlay && overlay.classList.contains('show') && event.target === overlay) {
            closeAdminPreview();
        }
    });
</script>
@endsection
