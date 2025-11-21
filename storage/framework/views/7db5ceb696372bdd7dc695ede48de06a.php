<?php $__env->startSection('title', 'ສ້າງຄຳຂໍເປີດບັນຊີໃໝ່'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $tellerProfile = $tellerProfile ?? auth()->user()->loadMissing(['branch', 'unit']);
?>
<style>
    * { font-family: 'Noto Sans Lao', 'Noto Sans', sans-serif; }

    :root {
        --apb-primary: #0f766e;
        --apb-accent: #14b8a6;
        --apb-light: #ecfdf5;
    }

    body { background: #F5F7FA; }

    .page-header { background: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 4px solid var(--apb-accent); }
    .page-header h4 { margin:0; color:#050505; font-weight:700; font-size:1.5rem; display:flex; align-items:center; gap:12px; }
    .page-subtitle { color:#000; font-size:0.9rem; margin:6px 0 0; }

    .form-card { background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; }
    .form-body { padding:30px; }
    .form-section { margin-bottom:30px; }
    .section-title { color:#000; font-weight:700; font-size:1.2em; margin-bottom:18px; padding-bottom:10px; border-bottom:2px solid #f0f0f0; display:flex; align-items:center; gap:10px; }
    .section-title i { color: var(--apb-accent); font-size:1.3rem; }
    .form-label { font-weight:600; color:#000; margin-bottom:8px; font-size:1em; display:flex; align-items:center; gap:6px; }
    .form-label i { color:#6c757d; font-size:0.95rem; }
    .required { color:#dc3545; font-weight:700; }
    .form-control, .form-select { border:1px solid #ced4da; border-radius:8px; padding:11px 14px; transition:all 0.3s ease; font-size:0.9rem; }
    .form-control:focus, .form-select:focus { border-color: var(--apb-accent); box-shadow:0 0 0 0.2rem rgba(76,175,80,0.15); background:#fff; }

    /* File upload */
    .file-upload-container { margin-bottom:20px; }
    .file-upload-area { border:3px dashed #B0BEC5; border-radius:10px; padding:30px 20px; text-align:center; background:#FAFAFA; transition:all 0.3s ease; cursor:pointer; }
    .file-upload-area:hover { border-color:var(--apb-accent); background:#fff; transform:translateY(-2px); box-shadow:0 4px 12px rgba(76,175,80,0.1); }
    .file-upload-area.dragover { border-color:var(--apb-accent); background:var(--apb-light); transform:scale(1.02); }
    .file-upload-icon { font-size:3.5rem; color:var(--apb-accent); margin-bottom:16px; display:block; animation:float 3s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-10px);} }
    .file-upload-text { color:var(--apb-primary); font-weight:700; font-size:1.1rem; margin-bottom:8px; }
    .file-upload-hint { color:#78909C; font-size:0.9rem; margin-bottom:12px; }
    .file-upload-formats { display:flex; justify-content:center; gap:12px; margin-top:16px; flex-wrap:wrap; }
    .format-badge { background:#fff; border:2px solid #E0E0E0; padding:6px 14px; border-radius:20px; font-size:0.8rem; font-weight:600; color:#546E7A; }
    .file-list { margin-top:20px; }
    .file-item { background:#fff; border:2px solid #E0E0E0; border-radius:10px; padding:14px 18px; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between; transition:all 0.3s ease; }
    .file-item:hover { border-color:var(--apb-accent); box-shadow:0 2px 8px rgba(0,0,0,0.06); }
    .file-info { display:flex; align-items:center; gap:12px; flex:1; }
    .file-icon { width:40px; height:40px; background:var(--apb-light); border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--apb-accent); font-size:1.3rem; }
    .file-details { flex:1; }
    .file-name { font-weight:600; color:#212529; margin-bottom:2px; font-size:0.9rem; }
    .file-size { color:#78909C; font-size:0.8rem; }
    .file-remove { background:#FFEBEE; border:2px solid #FFCDD2; color:#C62828; width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.3s ease; font-size:1.1rem; }
    .file-remove:hover { background:#EF5350; color:#fff; transform:scale(1.1); }

    .form-actions { padding:24px 32px; background:linear-gradient(to right,#FAFAFA,#F5F5F5); border-top:2px solid #E0E0E0; display:flex; justify-content:space-between; gap:16px; }
    .btn-submit { background:linear-gradient(135deg, var(--apb-primary) 0%, var(--apb-accent) 100%); border:none; color:#fff; padding:14px 32px; border-radius:10px; font-weight:700; display:inline-flex; align-items:center; gap:10px; font-size:1rem; box-shadow:0 4px 12px rgba(76,175,80,0.2); }
    .btn-back { background:#fff; border:2px solid #f70000; color:#000; padding:14px 32px; border-radius:10px; font-weight:700; display:inline-flex; align-items:center; gap:10px; text-decoration:none; font-size:1rem; }
    .btn-submit:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(76,175,80,0.3); color:#fff; }
    .btn-back:hover { background:#ff0000; color:#fff; border-color:#ff0000; transform:translateY(-3px); }

    @media (max-width:768px) {
        .page-header { padding:24px 20px; }
        .page-header h4 { font-size:1.4rem; }
        .form-body, .form-actions { padding:24px 20px; }
        .form-actions { flex-direction:column-reverse; }
        .form-actions button, .form-actions a { width:100%; justify-content:center; }
        .file-upload-area { padding:30px 20px; }
        .file-upload-formats { flex-wrap:wrap; }
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <h4><i class="bi bi-file-earmark-plus"></i> ສ້າງຄຳຂໍເປີດບັນຊີໃໝ່</h4>
        <p class="page-subtitle">ກະລຸນາຕື່ມຂໍ້ມູນໃຫ້ຄົບຖ້ວນ ແລະ ຖືກຕ້ອງ</p>
    </div>

    <form method="POST" action="<?php echo e(route('teller.requests.store')); ?>" enctype="multipart/form-data" class="form-card" id="mainForm">
        <?php echo csrf_field(); ?>
        <div class="form-body">
            <div class="help-text">
                <i class="bi bi-info-circle-fill"></i>
                <strong>ໝາຍເຫດ:</strong> ຊ່ອງທີ່ມີເຄື່ອງໝາຍ <span class="required">*</span> ແມ່ນຈຳເປັນຕ້ອງຕື່ມ
            </div>

            <!-- Store Info -->
            <div class="form-section">
                <div class="section-title"><i class="bi bi-shop"></i> ຂໍ້ມູນຮ້ານຄ້າ</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-building"></i> ຊື່ຮ້ານຄ້າ <span class="required">*</span></label>
                        <input type="text" name="store_name" class="form-control" required placeholder="ປ້ອນຊື່ຮ້ານຄ້າ" value="<?php echo e(old('store_name')); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-briefcase"></i> ປະເພດທຸລະກິດ <span class="required">*</span></label>
                        <input type="text" name="business_type" class="form-control" required placeholder="ເຊັ່ນ: ຮ້ານອາຫານ, ຮ້ານຂາຍເຄື່ອງ" value="<?php echo e(old('business_type')); ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt"></i> ທີ່ຢູ່ຮ້ານຄ້າ <span class="required">*</span></label>
                    <textarea name="store_address" class="form-control" rows="3" required placeholder="ປ້ອນທີ່ຢູ່ຮ້ານຄ້າແບບລະອຽດ (ບ້ານ, ເມືອງ, ແຂວງ)"><?php echo e(old('store_address')); ?></textarea>
                </div>
            </div>

            <!-- POS & Bank -->
            <div class="form-section">
                <div class="section-title"><i class="bi bi-credit-card"></i> ຂໍ້ມູນ POS ແລະ ບັນຊີທະນາຄານ</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-upc-scan"></i> ໝາຍເລກເຄື່ອງ POS <span class="required">*</span></label>
                        <input type="text" name="pos_serial" class="form-control" required placeholder="ເຊັ່ນ: POS-2024-001" value="<?php echo e(old('pos_serial')); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-bank"></i> ເລກບັນຊີທະນາຄານ</label>
                        <input type="text" name="bank_account" class="form-control" placeholder="ປ້ອນເລກບັນຊີ (ຖ້າມີ)" value="<?php echo e(old('bank_account')); ?>">
                    </div>
                </div>
            </div>

            <!-- Installation -->
            <div class="form-section">
                <div class="section-title"><i class="bi bi-calendar-check"></i> ຂໍ້ມູນການຕິດຕັ້ງ</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="bi bi-calendar3"></i> ວັນທີຕິດຕັ້ງ <span class="required">*</span></label>
                        <input type="date" name="installation_date" class="form-control" required value="<?php echo e(old('installation_date', date('Y-m-d'))); ?>">
                    </div>
                </div>
            </div>

            <!-- File Upload -->
            <div class="form-section">
                <div class="section-title"><i class="bi bi-paperclip"></i> ເອກະສານແນບ (ອັບໂຫລດຫຼາຍໄຟລ໌ໄດ້)</div>
                <div class="file-upload-container">
                    <div class="file-upload-area" id="dropArea">
                        <input type="file" name="attachments[]" id="fileInput" class="d-none" accept=".pdf,.jpg,.jpeg,.png" multiple>
                        <div>
                            <i class="bi bi-cloud-upload file-upload-icon"></i>
                            <div class="file-upload-text">ລາກໄຟລ໌ມາວາງທີ່ນີ້ ຫຼື ຄລິກເພື່ອເລືອກ</div>
                            <div class="file-upload-hint">ສາມາດອັບໂຫລດຫຼາຍໄຟລ໌ພ້ອມກັນ (ແຕ່ລະໄຟລ໌ສູງສຸດ 5MB)</div>
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
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('teller.dashboard')); ?>" class="btn-back"><i class="bi bi-arrow-left"></i> ກັບຄືນ</a>
            <button type="submit" class="btn-submit"><i class="bi bi-send-fill"></i> ສົ່ງຄຳຂໍ</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    let selectedFiles = [];

    dropArea.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', e => handleFiles(e.target.files));

    ['dragenter','dragover','dragleave','drop'].forEach(ev => {
        dropArea.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); });
    });
    ['dragenter','dragover'].forEach(ev => dropArea.addEventListener(ev, () => dropArea.classList.add('dragover')));
    ['dragleave','drop'].forEach(ev => dropArea.addEventListener(ev, () => dropArea.classList.remove('dragover')));
    dropArea.addEventListener('drop', e => handleFiles(e.dataTransfer.files));

    function handleFiles(files) {
        const validTypes = ['application/pdf','image/jpeg','image/jpg','image/png'];
        const maxSize = 5 * 1024 * 1024;
        [...files].forEach(file => {
            if (!validTypes.includes(file.type)) {
                alert(`ໄຟລ໌ ${file.name} ບໍ່ຖືກຕ້ອງ. ກະລຸນາເລືອກ PDF, JPG, ຫຼື PNG ເທົ່ານັ້ນ.`);
                return;
            }
            if (file.size > maxSize) {
                alert(`ໄຟລ໌ ${file.name} ມີຂະໜາດໃຫຍ່ເກີນ 5MB.`);
                return;
            }
            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
            }
        });
        updateFileList();
        updateFileInput();
    }

    function updateFileList() {
        fileList.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const div = document.createElement('div');
            div.className = 'file-item';
            div.innerHTML = `
                <div class="file-info">
                    <div class="file-icon"><i class="bi bi-${getFileIcon(file.type)}"></i></div>
                    <div class="file-details">
                        <div class="file-name">${file.name}</div>
                        <div class="file-size">${formatFileSize(file.size)}</div>
                    </div>
                </div>
                <button type="button" class="file-remove" onclick="removeFile(${index})"><i class="bi bi-x-lg"></i></button>
            `;
            fileList.appendChild(div);
        });
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updateFileList();
        updateFileInput();
    };

    function getFileIcon(type) {
        if (type === 'application/pdf') return 'file-pdf-fill';
        if (type.startsWith('image/')) return 'file-image-fill';
        return 'file-earmark-fill';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes','KB','MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.teller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/teller/requests/create.blade.php ENDPATH**/ ?>