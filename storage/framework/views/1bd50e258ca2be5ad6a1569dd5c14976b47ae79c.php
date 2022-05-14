
<?php $__env->startSection('title'); ?> <?php echo e(__('Appointment list')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Create Category</h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="detail_box">
                                <div class="detail_box">
                                    <form action="<?php echo e(route('StoreCategory')); ?>" name="doctorform" class="" method="post">
                                        <?php echo csrf_field(); ?>

                                        <table class="table sislac_table table_form">
                                            <thead>
                                            <tr>
                                                <th>Abbreviation</th>
                                                <th>Name</th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                            <th><input class="form-control" name="abbreviation" type="text" /></th>
                                            <th><input class="form-control" name="category_name" type="text" /></th>

                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/exam/createcategory.blade.php ENDPATH**/ ?>