
<?php $__env->startSection('title'); ?> <?php echo e(__('Appointment list')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <body data-topbar="dark" data-layout="horizontal">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="row">
            <div class="col-lg-3">

                    <a href="<?php echo e(route('CreateCategory')); ?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('Add New Category')); ?>

                        </button>
                    </a>

            </div>

            <div class="col-lg-9 text-right">

                <form action="">
                    <div class="form-group d-inline-flex">
                        <input class="form-control mr-1" type="text" placeholder="Search AB" name="search_abbreviation"  />
                        <input class="form-control mr-1" type="text" placeholder="Search Name" name="search_name"  />
                        <button type="submit" value="" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="detail_box">
                            <table class="table sislac_table table_form">
                                <thead>
                                <tr>
                                    <th>Abbreviation</th>
                                    <th>Name</th>
                                    <th>Options</th>

                                </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th> <?php echo e($item->abbreviation); ?></th>
                                            <th> <?php echo e($item->name); ?></th>


                                            <th>
                                                <a href="">
                                                    <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="Update Profile">
                                                        <i class="mdi mdi-lead-pencil"></i>
                                                    </button>
                                                </a>
                                                <a href=" javascript:void(0) ">
                                                    <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="Deactivate Profile"
                                                            id="delete-doctor">
                                                        <i class="mdi mdi-trash-can"></i>
                                                    </button>
                                                </a>
                                            </th>

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/exam/category.blade.php ENDPATH**/ ?>