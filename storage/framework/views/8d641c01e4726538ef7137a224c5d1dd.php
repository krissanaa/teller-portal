<style>
    .apb-pagination {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0;
        margin: 0;
        list-style: none;
        background: #f8fafc;
        border-radius: 12px;
    }

    .apb-pagination .page-item {
        list-style: none;
    }

    .apb-pagination .page-link {
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #475569;
        padding: 8px 12px;
        min-width: 38px;
        text-align: center;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .apb-pagination .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        text-decoration: none;
        color: #0f172a;
    }

    .apb-pagination .page-item.disabled .page-link {
        background: #f8fafc;
        color: #cbd5e1;
        border-color: #e2e8f0;
        box-shadow: none;
        cursor: not-allowed;
    }

    .apb-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(20, 184, 166, 0.35);
    }
</style>

<ul class="apb-pagination">
    
    <?php if($paginator->onFirstPage()): ?>
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
        </li>
    <?php else: ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
    <?php endif; ?>

    
    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <?php if(is_string($element)): ?>
            <li class="page-item disabled" aria-disabled="true"><span class="page-link"><?php echo e($element); ?></span></li>
        <?php endif; ?>

        
        <?php if(is_array($element)): ?>
            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                    <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e($page); ?></span></li>
                <?php else: ?>
                    <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php if($paginator->hasMorePages()): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    <?php else: ?>
        <li class="page-item disabled" aria-disabled="true">
            <span class="page-link" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
        </li>
    <?php endif; ?>
</ul>
<?php /**PATH /var/www/html/resources/views/vendor/pagination/custom.blade.php ENDPATH**/ ?>