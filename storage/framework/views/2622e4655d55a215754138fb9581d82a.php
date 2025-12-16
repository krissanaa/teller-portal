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
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
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

    /* Lightbox */
    .attachment-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.9);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
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
        width: auto;
        max-width: 90vw;
        max-height: 90vh;
        background: transparent;
        display: flex;
        flex-direction: column;
    }

    .lightbox-body img {
        max-width: 100%;
        max-height: 85vh;
        border-radius: 4px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .lightbox-close {
        position: absolute;
        top: -3rem;
        right: 0;
        color: white;
        background: transparent;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        opacity: 0.8;
    }

    .lightbox-close:hover {
        opacity: 1;
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
            $url = asset('storage/' . ltrim($path, '/'));
            $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            ?>
            <button type="button"
                class="attachment-pill"
                onclick="openAdminPreview('<?php echo e($url); ?>', '<?php echo e(addslashes($fileName)); ?>', '<?php echo e($extension); ?>')">
                <?php if(in_array($extension, ['jpg','jpeg','png','gif'])): ?>
                <span style="width:42px;height:42px;border-radius:12px;overflow:hidden;display:inline-flex;">
                    <img src="<?php echo e($url); ?>" alt="<?php echo e($fileName); ?>" style="width:100%;height:100%;object-fit:cover;">
                </span>
                <?php elseif($extension === 'pdf'): ?>
                <span style="width:42px;height:42px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;background:#fef2f2;color:#b91c1c;font-weight:700;">
                    PDF
                </span>
                <?php else: ?>
                <i class="bi bi-paperclip"></i>
                <?php endif; ?>
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

<div id="attachmentLightbox" class="attachment-lightbox d-none">
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeAdminPreview()">&times;</button>
        <div class="lightbox-body" id="lightboxBody"></div>
    </div>
</div>

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