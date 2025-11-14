<?php $__env->startSection('title', 'Teller Management'); ?>


<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn-gradient">
        <i class="bi bi-person-plus"></i>
        Create Teller
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="filter-card">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="search" class="form-label">Search by name, teller ID, or phone</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="<?php echo e($search); ?>"
                    class="form-control"
                    placeholder="Enter keyword...">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn-filter w-100">
                    <i class="bi bi-search"></i> Search
                </button>
            </div>
            <?php if(!empty($search)): ?>
                <div class="col-md-3">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary w-100" style="border-radius: 10px; padding: 12px 18px;">
                        Clear Filter
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h5>All Teller Accounts</h5>
            <span class="meta"><?php echo e($users->total()); ?> total</span>
        </div>
        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($u->id); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.users.show', $u->id)); ?>">
                                <?php echo e($u->name); ?>

                            </a>
                        </td>
                        <td><?php echo e($u->email); ?></td>
                        <td><?php echo e($u->phone); ?></td>
                        <td>
                            <span class="status-pill <?php echo e($u->status); ?>">
                                <?php if($u->status === 'approved'): ?>
                                    <i class="bi bi-check-circle"></i>
                                <?php elseif($u->status === 'pending'): ?>
                                    <i class="bi bi-clock-history"></i>
                                <?php else: ?>
                                    <i class="bi bi-x-circle"></i>
                                <?php endif; ?>
                                <?php echo e(ucfirst($u->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($u->created_at->format('Y-m-d')); ?></td>
                        <td>
                            <div class="action-buttons justify-content-center">
                                <?php if($u->status !== 'approved'): ?>
                                    <form action="<?php echo e(route('admin.users.updateStatus', $u->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-action approve">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>
                                <?php endif; ?>

                                <?php if($u->status !== 'rejected'): ?>
                                    <form action="<?php echo e(route('admin.users.updateStatus', $u->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn-action reject">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No teller accounts found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($users->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>