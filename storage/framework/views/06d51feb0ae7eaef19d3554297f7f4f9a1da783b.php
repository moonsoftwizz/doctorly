<?php if(!empty($notification_count)): ?>
    <?php $__currentLoopData = $notification_count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="/notification/<?php echo e($item->id); ?>" class="text-reset notification-item">
            <div class="media">
                <img src="<?php if($item->user->profile_photo != ''): ?><?php echo e(URL::asset('storage/images/users/' . $item->user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/noImage.png')); ?><?php endif; ?>"
                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                <div class="media-body">
                    <h6 class="mt-0 mb-1"><?php echo e($item->user->first_name .' '.$item->user->last_name); ?></h6>
                    <div class="font-size-12 text-muted">
                        <p class="mb-1"><?php echo e($item->title); ?></p>
                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?php echo e($item->created_at->diffForHumans()); ?></p>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/layouts/ajax-notification.blade.php ENDPATH**/ ?>