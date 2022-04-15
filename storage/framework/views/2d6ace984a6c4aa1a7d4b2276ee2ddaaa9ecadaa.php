<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18"><?php echo e($title); ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e($li_1); ?></a></li>
                    <?php if(isset($li_2)): ?>
                    <li class="breadcrumb-item"><?php echo e($li_2); ?></li>
                    <?php endif; ?>
                    <?php if(isset($li_3)): ?>
                    <li class="breadcrumb-item"><?php echo e($li_3); ?></li>
                    <?php endif; ?>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>