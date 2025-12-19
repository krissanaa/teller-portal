

<?php $__env->startSection('title', 'Onboarding Requests'); ?>

<?php $__env->startSection('content'); ?>
<?php
use Illuminate\Support\Str;

$statusClassMap = [
'approved' => 'status-pill approved',
'rejected' => 'status-pill rejected',
'pending' => 'status-pill pending',
];
?>

<style>
    :root {
        --apb-primary: #14b8a6;
        --apb-secondary: #0f766e;
        --apb-accent: #14b8a6;
        --apb-dark: #0b3f3a;
        --bg-color: #f1f5f9;
        --card-bg: #ffffff;
        --text-dark: #334155;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    body {
        font-family: 'Inter', 'Noto Sans Lao', sans-serif;
        background: var(--bg-color);
        color: var(--text-dark);
        font-size: 0.9375rem;
        /* Bigger base font */
        line-height: 1.5;
    }

    .onboarding-shell {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    .page-heading {
        font-size: 1.5rem;
        /* Bigger heading */
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-stack {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        /* Keep compact gap */
    }

    .request-card {
        background: white;
        border-radius: 6px;
        padding: 0.875rem;
        /* Keep compact padding */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
        border-left: 3px solid var(--apb-primary);
        border-top: 1px solid var(--border-color);
        transition: all 0.15s ease;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .request-card:hover {
        background-color: #e6fffa;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-color: var(--apb-primary);
    }

    /* Header Section */
    .card-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .request-title {
        font-size: 1.25rem;
        /* Bigger title */
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1.3;
    }

    .meta-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.15rem;
        color: var(--text-muted);
        font-size: 0.9375rem;
        /* Bigger meta text */
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Info Grid */
    .info-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 0.5rem;
        padding: 0.5rem;
        background: #f8fafc;
        border-radius: 4px;
        border: 1px solid #f1f5f9;
    }

    .info-chip {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-chip i {
        color: var(--apb-primary);
        font-size: 1.125rem;
        /* Bigger icon */
        opacity: 0.8;
    }

    .info-chip .text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .info-chip small {
        font-size: 0.75rem;
        /* Bigger label */
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 600;
        letter-spacing: 0.025em;
    }

    .info-chip strong {
        font-size: 1rem;
        /* Bigger value */
        color: #334155;
        font-weight: 600;
    }

    /* Status Pills */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.8125rem;
        /* Bigger pill text */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        line-height: 1;
    }

    .status-pill::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .status-pill.approved {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #d1fae5;
    }

    .status-pill.approved::before {
        background: #059669;
    }

    .status-pill.pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .status-pill.pending::before {
        background: #d97706;
    }

    .status-pill.rejected {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .status-pill.rejected::before {
        background: #dc2626;
    }

    /* Tags & Attachments */
    .tag-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        font-size: 0.875rem;
        /* Bigger tag text */
    }

    .tag-row span {
        background: white;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        border-radius: 3px;
        padding: 3px 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .tag-row span i {
        color: var(--apb-accent);
        font-size: 0.875rem;
    }

    .attachment-box {
        margin-top: 0.25rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
    }

    .attachment-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: 1px solid #e2e8f0;
        border-radius: 3px;
        padding: 4px 10px;
        background: #fff;
        text-decoration: none;
        color: var(--text-dark);
        font-size: 0.875rem;
        /* Bigger attachment text */
        font-weight: 500;
        transition: all 0.15s ease;
    }

    .attachment-pill:hover {
        border-color: var(--apb-primary);
        color: var(--apb-primary);
        background: #f0fdfa;
    }

    /* Actions */
    .card-footer {
        margin-top: 0.25rem;
        padding-top: 0.75rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 0.5rem;
    }



    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem 1.5rem;
        background: white;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 1rem 1.5rem;
        background: #f8fafc;
    }

    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--apb-accent);
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }

    /* Dark Preview Modal styles */
    .modal-preview-dark .modal-content {
        background-color: transparent;
        box-shadow: none;
        border: none;
        height: 100vh;
        pointer-events: none;
    }

    .modal-preview-dark .modal-body {
        background-color: transparent;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        height: 100%;
        pointer-events: auto;
        cursor: pointer;
    }

    .modal-preview-dark .preview-container {
        cursor: default;
        background: #1e293b;
        border-radius: 12px;
        padding: 2px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        display: inline-block;
        position: relative;
        max-width: 100%;
        max-height: 90vh;
    }

    .modal-preview-dark .modal-header {
        position: fixed;
        top: 20px;
        right: 20px;
        left: auto;
        width: auto;
        border: none;
        background: transparent;
        padding: 0;
        z-index: 1056;
    }

    @media (max-width: 640px) {
        .info-strip {
            grid-template-columns: 1fr;
        }

    }

    /* Pagination - Teller Style */
    .pagination svg {
        width: 16px !important;
        height: 16px !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        margin: 0;
    }

    .pagination .page-link {
        color: #64748b;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 4px 8px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        min-width: 28px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%);
        border-color: #14b8a6;
        color: white;
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.4);
        transform: scale(1.05);
    }

    .pagination .page-item.disabled .page-link {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        cursor: not-allowed;
        box-shadow: none;
        pointer-events: none;
    }

    .pagination .page-item.disabled .page-link:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #cbd5e1;
        transform: none;
        box-shadow: none;
    }
</style>




<div class="card-stack">
    <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <?php
    $created = optional($req->created_at)?->format('M d, Y \\a\\t h:i A');
    $attachments = is_array($req->attachments)
    ? $req->attachments
    : (is_string($req->attachments) ? json_decode($req->attachments ?? '[]', true) : []);
    ?>
    <div class="request-card">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <div>
                <?php if($status !== 'pending'): ?>
                <span class="<?php echo e($statusClassMap[$req->approval_status] ?? 'status-pill pending'); ?>">
                    <?php echo e(ucfirst($req->approval_status)); ?>

                </span>
                <?php endif; ?>
                <h2 class="request-title mb-0"><?php echo e($req->store_name ?? 'Unnamed Store'); ?></h2>
                <div class="text-black fw-bold mt-1" style="font-size: 15px">
                    <i class="bi bi-briefcase"></i> <?php echo e($req->business_type ?? '-'); ?>

                </div>
                <div class="text-black fw-bold small mt-1" style="font-size: 15px">
                    <i class="bi bi-geo-alt"></i> <?php echo e($req->store_address ?? 'N/A'); ?>

                </div>
            </div>
            <div class="text-end">
                <div class="fw-semibold" style="color: #0f172a;">
                    <?php echo e(optional($req->teller)->name ? optional($req->teller)->name .' ('. $req->teller_id .')' : ($req->teller_id ?? '-')); ?>

                </div>
                <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px; display: flex; flex-direction: column; gap: 2px; align-items: flex-end;">
                    <span><i class="bi bi-building" style="color: var(--apb-primary); margin-right: 4px;"></i><?php echo e(optional(optional($req->teller)->branch)->name ?? '-'); ?></span>
                    <span><i class="bi bi-diagram-3" style="color: var(--apb-primary); margin-right: 4px;"></i><?php echo e(optional(optional($req->teller)->unit)->name ?? '-'); ?></span>
                    <span><i class="bi bi-telephone" style="color: var(--apb-primary); margin-right: 4px;"></i><?php echo e(optional($req->teller)->phone ?? '-'); ?></span>
                </div>
                <?php if($created): ?>
                <small class="text-muted d-block mt-2">
                    <i class="bi bi-calendar-event"></i> Submitted <?php echo e($created); ?>

                </small>
                <?php endif; ?>
            </div>
        </div>

        <div class="info-strip">
            <div class="info-chip">
                <i class="bi bi-upc"></i>
                <div class="text">
                    <small>Refer ID</small>
                    <strong><?php echo e($req->refer_code ?? 'N/A'); ?></strong>
                </div>
            </div>
            <div class="info-chip">
                <i class="bi bi-bank"></i>
                <div class="text">
                    <small>Bank Account</small>
                    <strong><?php echo e($req->bank_account ?? '-'); ?></strong>
                </div>
            </div>
            <div class="info-chip">
                <i class="bi bi-calendar-check"></i>
                <div class="text">
                    <small>Install Date</small>
                    <strong><?php echo e($req->installation_date ? \Carbon\Carbon::parse($req->installation_date)->format('M d, Y') : '-'); ?></strong>
                </div>
            </div>
            <div class="info-chip">
                <i class="bi bi-hdd-network"></i>
                <div class="text">
                    <small>Total POS</small>
                    <strong><?php echo e($req->total_device_pos ?? '1'); ?></strong>
                </div>
            </div>
        </div>

        <?php if(count($attachments)): ?>
        <div class="attachment-box">
            <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $fileName = basename($path);

            // Use relative storage-file route for consistent access
            $encodedPath = str_replace('%2F', '/', rawurlencode($path));
            $url = '/storage-file/' . $encodedPath;
            $publicUrl = asset('storage/' . ltrim($path, '/'));

            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            ?>
            <button type="button"
                class="attachment-pill"
                onclick="openAdminPreview('<?php echo e($url); ?>', '<?php echo e(addslashes($fileName)); ?>', '<?php echo e($extension); ?>', '<?php echo e($publicUrl); ?>')">
                <span class="me-2 d-inline-flex align-items-center justify-content-center rounded"
                    style="width:42px;height:42px;background:#f8fafc;border:1px solid #e2e8f0;">
                    <?php if(in_array($extension, ['jpg','jpeg','png','gif','webp'])): ?>
                    <img src="<?php echo e($url); ?>" data-fallback="<?php echo e($publicUrl); ?>" alt="<?php echo e($fileName); ?>"
                        onerror="this.onerror=null; if(this.dataset.fallback) this.src=this.dataset.fallback;"
                        style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                    <?php elseif($extension === 'pdf'): ?>
                    <canvas data-pdf-mini-thumb data-url="<?php echo e($url); ?>"
                        style="width:38px;height:38px;border-radius:10px;display:inline-block;background:#f1f5f9;"></canvas>
                    <?php else: ?>
                    <i class="bi bi-paperclip text-secondary"></i>
                    <?php endif; ?>
                </span>
                <?php echo e(Str::limit($fileName, 24)); ?>

            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if($req->approval_status === 'pending'): ?>
        <div class="card-footer d-flex gap-2">
            <button class="btn btn-success btn-sm" type="button"
                data-bs-toggle="modal"
                data-bs-target="#approveModal"
                data-request-id="<?php echo e($req->id); ?>"
                data-store="<?php echo e($req->store_name); ?>"
                data-refer="<?php echo e($req->refer_code); ?>"
                data-pos-serial="<?php echo e($req->pos_serial ?? ''); ?>"
                data-total-pos="<?php echo e($req->total_device_pos ?? 1); ?>">
                Approve & assign POS
            </button>
            <button class="btn btn-danger btn-sm" type="button"
                data-bs-toggle="modal"
                data-bs-target="#rejectModal"
                data-request-id="<?php echo e($req->id); ?>"
                data-store="<?php echo e($req->store_name); ?>"
                data-refer="<?php echo e($req->refer_code); ?>">
                Reject
            </button>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="text-center border rounded-4 py-5" style="border-color: rgba(28, 114, 75, 0.2); background: #f8fdf9;">
        <i class="bi bi-inbox fs-1 text-success mb-2"></i>
        <p class="mb-0 fw-semibold text-muted">No onboarding requests found.</p>
    </div>
    <?php endif; ?>
</div>

<div class="position-relative mt-4">
    <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 1;">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
            <i class="bi bi-house"></i> Back to Home
        </a>
    </div>
    <div class="d-flex flex-column align-items-end">
        <div class="text-muted small mb-2">
            <?php
            $start = $requests->firstItem() ?? 0;
            $end = $requests->lastItem() ?? 0;
            $total = $requests->total() ?? 0;
            ?>
            Showing <?php echo e($start); ?> to <?php echo e($end); ?> of <?php echo e($total); ?> results
        </div>
        <div>
            <?php if($requests->hasPages()): ?>
            <?php echo e($requests->links('vendor.pagination.custom')); ?>

            <?php else: ?>
            <ul class="apb-pagination">
                <li class="page-item disabled"><span class="page-link" aria-hidden="true"><i class="bi bi-chevron-left"></i></span></li>
                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                <li class="page-item disabled"><span class="page-link" aria-hidden="true"><i class="bi bi-chevron-right"></i></span></li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>

<!-- Dark Preview Modal -->
<div class="modal fade modal-preview-dark" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="preview-container" style="min-width: 300px; min-height: 200px;">
                    <img id="previewImage" src="" alt="Preview" class="img-fluid d-none rounded" style="max-height: 80vh; max-width: 100%; object-fit: contain;">
                    <div id="previewPdfCanvasWrap" class="d-none rounded bg-white" style="width: 100%; height: 80vh; overflow: auto;">
                        <div id="previewPdfStatus" class="sticky-top bg-warning text-dark small py-1 shadow-sm">Loading PDF...</div>
                        <div id="previewPdfPages" class="d-flex flex-column align-items-center gap-3 p-3 bg-dark"></div>
                    </div>
                    <iframe id="previewFrame" src="" class="w-100 d-none rounded bg-white" style="height: 80vh; border: 0;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="approveModalLabel">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Approve Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST"
                action="<?php echo e(route('admin.onboarding.approve', '__REQUEST_ID__')); ?>"
                data-base-action="<?php echo e(route('admin.onboarding.approve', '__REQUEST_ID__')); ?>"
                id="approveForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text-muted mb-4" id="approve_request_info"></p>
                    <label class="form-label fw-bold text-dark small text-uppercase">POS Serials (Required)</label>
                    <input type="hidden" name="pos_serial" id="legacy_pos_serial_hidden"> <!-- Fallback/Container -->
                    <div id="dynamic_pos_inputs">
                        <!-- Inputs will be injected here via JS -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="rejectModalLabel">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    Reject Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST"
                action="<?php echo e(route('admin.onboarding.reject', '__REQUEST_ID__')); ?>"
                data-base-action="<?php echo e(route('admin.onboarding.reject', '__REQUEST_ID__')); ?>"
                id="rejectForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="request_id" id="modal_request_id">
                    <p class="text-muted mb-4" id="modal_request_info"></p>
                    <label for="modal_admin_remark" class="form-label fw-bold text-dark small text-uppercase">Rejection Reason</label>
                    <textarea
                        name="admin_remark"
                        id="modal_admin_remark"
                        class="form-control"
                        rows="3"
                        required
                        placeholder="Please provide a reason for rejection..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAdminPreview(fileUrl, fileName, extension, fallbackUrl = '') {
        const modalEl = document.getElementById('previewModal');
        const img = document.getElementById('previewImage');
        const frame = document.getElementById('previewFrame');
        const pdfWrap = document.getElementById('previewPdfCanvasWrap');
        const pdfPages = document.getElementById('previewPdfPages');
        const pdfStatus = document.getElementById('previewPdfStatus');

        // Reset state
        img.classList.add('d-none');
        frame.classList.add('d-none');
        if (pdfWrap) pdfWrap.classList.add('d-none');
        img.src = '';
        frame.src = '';

        const ext = (extension || '').toLowerCase();
        if (ext === 'pdf') {
            renderPdfInModal(fileUrl, pdfWrap, pdfPages, pdfStatus, frame);
        } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
            // Prefer direct storage asset to avoid auth-blocked routes; fall back to storage-file
            const primary = fallbackUrl || fileUrl;
            img.onerror = () => {
                if (img.src !== fileUrl) {
                    img.onerror = null;
                    img.src = fileUrl; // try storage-file second
                }
            };
            img.src = primary;
            img.classList.remove('d-none');
        } else {
            frame.src = fileUrl;
            img.classList.add('d-none');
            frame.classList.remove('d-none');
        }

        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    async function renderPdfInModal(url, wrap, pagesContainer, status, iframeFallback) {
        if (!wrap || !pagesContainer) {
            if (iframeFallback) {
                iframeFallback.src = url;
                iframeFallback.classList.remove('d-none');
            }
            return;
        }

        wrap.classList.remove('d-none');
        pagesContainer.innerHTML = ''; // Clear previous pages

        if (status) {
            status.textContent = 'Loading PDF...';
            status.classList.remove('d-none');
        }

        try {
            const loadingTask = pdfjsLib.getDocument({
                url,
                withCredentials: false
            });
            const pdf = await loadingTask.promise;

            status.textContent = `Rendering ${pdf.numPages} page(s)...`;

            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                const page = await pdf.getPage(pageNum);
                const viewport = page.getViewport({
                    scale: 1.5
                });

                const canvas = document.createElement('canvas');
                canvas.className = 'shadow-sm bg-white rounded';
                canvas.style.maxWidth = '100%';

                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                pagesContainer.appendChild(canvas);

                await page.render({
                    canvasContext: context,
                    viewport: viewport
                }).promise;
            }

            if (status) status.classList.add('d-none');

        } catch (err) {
            console.error('PDF preview failed, falling back to iframe:', err);
            wrap.classList.add('d-none');
            if (iframeFallback) {
                iframeFallback.src = url;
                iframeFallback.classList.remove('d-none');
            }
        } finally {
            if (status) status.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Modal Backdrop Click
        const previewModal = document.getElementById('previewModal');
        if (previewModal) {
            previewModal.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal-body') || e.target.classList.contains('modal-content')) {
                    const instance = bootstrap.Modal.getInstance(previewModal);
                    if (instance) instance.hide();
                }
            });
        }

        // Render PDF Mini Thumbs
        const pdfThumbs = document.querySelectorAll('[data-pdf-mini-thumb]');
        pdfThumbs.forEach(async (canvas) => {
            const url = canvas.dataset.url;
            if (!url) return;
            try {
                const loadingTask = pdfjsLib.getDocument({
                    url,
                    withCredentials: false
                });
                const pdf = await loadingTask.promise;
                const page = await pdf.getPage(1);

                const viewport = page.getViewport({
                    scale: 1
                });
                const desiredWidth = 42 * window.devicePixelRatio; // Match CSS width * pixel ratio
                const scale = desiredWidth / viewport.width;
                const scaledViewport = page.getViewport({
                    scale
                });

                const ctx = canvas.getContext('2d');
                canvas.width = scaledViewport.width;
                canvas.height = scaledViewport.height;

                await page.render({
                    canvasContext: ctx,
                    viewport: scaledViewport
                }).promise;
            } catch (e) {
                console.error('PDF Thumb error:', e);
                // Fallback to simple icon
                canvas.replaceWith(document.createRange().createContextualFragment(
                    '<span style="width:42px;height:42px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;background:#fef2f2;color:#b91c1c;font-weight:700;font-size:10px;">PDF</span>'
                ));
            }
        });
    });

    const approveModal = document.getElementById('approveModal');
    approveModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const requestId = button.getAttribute('data-request-id');
        const store = button.getAttribute('data-store') || '';
        const refer = button.getAttribute('data-refer') || '';
        const existingSerialStr = button.getAttribute('data-pos-serial') || '';
        const totalPos = parseInt(button.getAttribute('data-total-pos') || '1');

        approveModal.querySelector('#approve_request_info').textContent = `${store} (${refer})`;

        // Dynamic Inputs Generation
        const container = document.getElementById('dynamic_pos_inputs');
        container.innerHTML = ''; // Clear previous

        // Handle existing serials if any (comma separated)
        let existingSerials = existingSerialStr.split(',').map(s => s.trim()).filter(s => s);

        for (let i = 0; i < totalPos; i++) {
            const val = existingSerials[i] || '';
            const div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = `
                    <label class="small text-muted mb-1">Device #${i + 1}</label>
                    <input type="text" name="pos_serial[]" class="form-control" 
                           placeholder="Enter Serial Number for Device ${i + 1}" 
                           required value="${val}">
                `;
            container.appendChild(div);
        }

        const form = document.getElementById('approveForm');
        form.action = form.dataset.baseAction.replace('__REQUEST_ID__', requestId);
    });

    const rejectModal = document.getElementById('rejectModal');
    if (rejectModal) {
        rejectModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const requestId = button.getAttribute('data-request-id');
            const store = button.getAttribute('data-store');
            const refer = button.getAttribute('data-refer');

            rejectModal.querySelector('#modal_request_id').value = requestId;
            rejectModal.querySelector('#modal_request_info').textContent = `${store} (${refer})`;

            const form = document.getElementById('rejectForm');
            form.action = form.dataset.baseAction.replace('__REQUEST_ID__', requestId);
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/onboarding/index.blade.php ENDPATH**/ ?>