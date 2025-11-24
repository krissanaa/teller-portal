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
        --bg-color: #0d1b14;
        --card-bg: #ffffff;
        --card-border: rgba(19, 78, 74, 0.1);
        --brand-green: #1c724b;
        --brand-green-light: #e6f4ee;
        --brand-gray: #708090;
        --text-dark: #0f172a;
        --text-muted: #6b7280;
        --chip-bg: rgba(28, 114, 75, 0.08);
    }

    body {
        font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif;
        background: #ffffff;
        color: var(--text-dark);
    }

    .onboarding-shell {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem 1rem 3rem;
    }

    .page-heading {
        font-size: clamp(1.8rem, 3vw, 2.4rem);
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .card-stack {
        display: flex;
        flex-direction: column;
        gap: 1.3rem;
    }

    .request-card {
        border-radius: 24px;
        border: 1px solid rgba(28, 114, 75, 0.18);
        background: var(--card-bg);
        padding: 1.6rem;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    }

    .info-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-top: 1rem;
    }

    .info-chip {
        flex: 1 1 220px;
        min-width: 200px;
        border-radius: 18px;
        border: 1px solid rgba(28, 114, 75, 0.15);
        background: rgba(28, 114, 75, 0.06);
        padding: 0.7rem 0.95rem;
        display: inline-flex;
        align-items: flex-start;
        gap: 0.6rem;
    }

    .info-chip i {
        color: var(--brand-green);
        font-size: 1.1rem;
        margin-top: 0.15rem;
    }

    .info-chip .text {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .info-chip small {
        display: block;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
    }

    .info-chip strong {
        display: block;
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 700;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 1.1rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .status-pill.approved { background: rgba(28, 114, 75, 0.15); color: var(--brand-green); }
    .status-pill.pending { background: rgba(251, 191, 36, 0.25); color: #b45309; }
    .status-pill.rejected { background: rgba(239, 68, 68, 0.2); color: #b91c1c; }

    .request-title {
        margin: 0.5rem 0 0;
        font-size: 1.3rem;
        font-weight: 800;
        color: #000000;
    }

    .tag-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-top: 1rem;
    }

    .tag-row span {
        background: rgba(28, 114, 75, 0.12);
        color: var(--brand-green);
        border-radius: 999px;
        padding: 0.35rem 0.85rem;
        font-size: 0.78rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .attachment-box {
        margin-top: 1.25rem;
        border: 1px dashed rgba(28, 114, 75, 0.3);
        border-radius: 20px;
        padding: 0.9rem;
        background: #f8fefb;
    }

    .attachment-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid rgba(15, 23, 42, 0.1);
        border-radius: 14px;
        padding: 0.45rem 0.8rem;
        background: #fff;
        text-decoration: none;
        color: var(--text-dark);
        font-size: 0.85rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
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
        border: 1px solid rgba(255, 255, 255, 0.3);
        overflow: hidden;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
    }

    .lightbox-body {
        padding: 1rem;
        background: #ffffff;
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

    .card-footer {
        margin-top: 1.1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .btn-outline-primary {
        border-color: var(--brand-green);
        color: var(--brand-green);
        transition: background 0.2s ease, color 0.2s ease;
    }

    .btn-outline-primary:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }
    .btn-outline-secondary {
        border-color: #000000;
        color: #000000;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .btn-outline-secondary:hover {
        background: #b91c1c;
        border-color: #b91c1c;
        color: #fff;
    }

    @media (max-width: 640px) {
        .info-chip {
            flex-basis: 100%;
        }
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
                        <span class="<?php echo e($statusClassMap[$req->approval_status] ?? 'status-pill pending'); ?>">
                            <?php echo e(ucfirst($req->approval_status)); ?>

                        </span>
                        <h2 class="request-title mb-0"><?php echo e($req->store_name ?? 'Unnamed Store'); ?></h2>
                        <div class="text-black fw-bold mt-1" style="font-size: 15px">
                            <i class="bi bi-location"></i> <?php echo e($req->business_type ?? '-'); ?>

                        </div>

                        <div class="text-black fw-bold small mt-1" style="font-size: 15px">
                            <i class="bi bi-location"></i> <?php echo e($req->store_address ?? 'N/A'); ?>

                        </div>

                        <div class="text-black fw-bold small mt-1" style="font-size: 15px">
                            <i class="bi bi-location"></i> <?php echo e(optional($req->branch)->name ?? '-'); ?>

                        </div>


                    </div>
                    <div class="text-end">
                        <div class="fw-semibold">
                            <?php echo e(optional($req->teller)->name ? optional($req->teller)->name .' ('. $req->teller_id .')' : ($req->teller_id ?? '-')); ?>

                        </div>
                        <?php if($created): ?>
                            <small class="text-muted d-block">
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
                        <i class="bi bi-cpu"></i>
                        <div class="text">
                            <small>POS Serial</small>
                            <strong><?php echo e($req->pos_serial ?? '-'); ?></strong>
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
                </div>

                <div class="tag-row">
                    <span><i class="bi bi-info-circle"></i> Store status: <?php echo e(Str::title(str_replace('_', ' ', $req->store_status ?? 'unknown'))); ?></span>
                    <span><i class="bi bi-paperclip"></i> Attachments: <?php echo e(count($attachments)); ?></span>
                    <span><i class="bi bi-chat-text"></i> Admin remark: <?php echo e($req->admin_remark ?? '-'); ?></span>
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
                                data-pos-serial="<?php echo e($req->pos_serial ?? ''); ?>">
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

    <div class="mt-3">
        <?php echo e($requests->links()); ?>

    </div>
    <div class="text-center mt-4">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-house"></i> Back to Home
        </a>
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
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveModalLabel">
                    <i class="bi bi-check2-circle me-2"></i>
                    Approve request & add POS serial
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST"
                  action="<?php echo e(route('admin.onboarding.approve', '__REQUEST_ID__')); ?>"
                  data-base-action="<?php echo e(route('admin.onboarding.approve', '__REQUEST_ID__')); ?>"
                  id="approveForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="text-muted mb-3" id="approve_request_info"></p>
                    <label for="modal_pos_serial" class="form-label fw-semibold text-success small">POS Serial (required)</label>
                    <input
                        type="text"
                        name="pos_serial"
                        id="modal_pos_serial"
                        class="form-control"
                        required
                        placeholder="Example: POS-2024-001">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="bi bi-x-octagon me-2"></i>
                    Reject Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST"
                  action="<?php echo e(route('admin.onboarding.reject', '__REQUEST_ID__')); ?>"
                  data-base-action="<?php echo e(route('admin.onboarding.reject', '__REQUEST_ID__')); ?>"
                  id="rejectForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="request_id" id="modal_request_id">
                    <p class="text-muted mb-3" id="modal_request_info"></p>
                    <label for="modal_admin_remark" class="form-label fw-semibold text-danger small">Reject remark</label>
                    <textarea
                        name="admin_remark"
                        id="modal_admin_remark"
                        class="form-control"
                        rows="3"
                        required
                        placeholder="Example: Missing documents or incorrect POS serial"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const requestId = button.getAttribute('data-request-id');
            const store = button.getAttribute('data-store') || '';
            const refer = button.getAttribute('data-refer') || '';
            const serial = button.getAttribute('data-pos-serial') || '';

            approveModal.querySelector('#approve_request_info').textContent = `${store} (${refer})`;
            approveModal.querySelector('#modal_pos_serial').value = serial;

            const form = document.getElementById('approveForm');
            form.action = form.dataset.baseAction.replace('__REQUEST_ID__', requestId);
        });
    }

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