<?php $__env->startSection('title'); ?> <?php echo e(__('List of Doctors')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Doctor List <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Doctors <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div></div>
                <div class="card">
                    <div class="card-body">
                        <?php if($role != 'patient' && $role != 'receptionist'): ?>
                            <a href=" <?php echo e(route('doctor.create')); ?> ">
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                    <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('New Doctor')); ?>

                                </button>
                            </a>
                        <?php endif; ?>
                        <table class="table table-bordered dt-responsive nowrap "
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Sr. No')); ?></th>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Contact No')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <?php if($role != 'patient'): ?>
                                        <th><?php echo e(__('Option')); ?></th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(session()->has('page_limit')): ?>
                                    <?php
                                        $per_page = session()->get('page_limit');
                                    ?>
                                <?php else: ?>
                                    <?php
                                        $per_page = Config::get('app.page_limit');
                                    ?>
                                <?php endif; ?>
                                <?php
                                    $currentpage = $doctors->currentPage();
                                ?>
                                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td> <?php echo e($key + 1 + $per_page * ($currentpage - 1)); ?> </td>
                                        <td>
                                            <?php echo e($item->doctor['title']); ?>

                                        </td>
                                        <td> <?php echo e($item->first_name); ?> <?php echo e($item->last_name); ?> </td>
                                        <td> <?php echo e($item->mobile); ?> </td>
                                        <td> <?php echo e($item->email); ?> </td>
                                        <?php if($role != 'patient'): ?>
                                            <td>
                                                <?php if($role == 'admin'): ?>
                                                    <a href="<?php echo e(url('doctor/' . $item->id)); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="View Profile">
                                                            <i class="mdi mdi-eye"></i>
                                                        </button>
                                                    </a>
                                                <?php elseif($role == 'receptionist'): ?>
                                                    <a href="<?php echo e(url('doctor-view/' . $item->id)); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="View Profile">
                                                            <i class="mdi mdi-eye"></i>
                                                        </button>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if($role != 'receptionist'): ?>
                                                    <a href="<?php echo e(url('doctor/' . $item->id . '/edit')); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="Update Profile">
                                                            <i class="mdi mdi-lead-pencil"></i>
                                                        </button>
                                                    </a>
                                                    <a href=" javascript:void(0) ">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                            title="Deactivate Profile" data-id="<?php echo e($item->id); ?>"
                                                            id="delete-doctor">
                                                            <i class="mdi mdi-trash-can"></i>
                                                        </button>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing <?php echo e($doctors->firstItem()); ?> to <?php echo e($doctors->lastItem()); ?> of
                                <?php echo e($doctors->total()); ?> entries
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo e($doctors->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Plugins js -->
        <script src="<?php echo e(URL::asset('assets/libs/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/pdfmake/pdfmake.min.js')); ?>"></script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('assets/js/pages/notification.init.js')); ?>"></script>
        <script>
            // delete Coctor
            $(document).on('click', '#delete-doctor', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure want to delete doctor?')) {
                    $.ajax({
                        type: "DELETE",
                        url: 'doctor/' + id,
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            id:id,
                        },
                        beforeSend: function() {
                            $('#pageloader').show()
                        },
                        success: function(response) {
                            toastr.success(response.message, 'Success Alert', {
                                timeOut: 2000
                            });
                            location.reload();
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message,{
                                timeOut: 20000
                            });
                        },
                        complete: function() {
                            $('#pageloader').hide();
                        }
                    });
                }
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/doctor/doctors.blade.php ENDPATH**/ ?>