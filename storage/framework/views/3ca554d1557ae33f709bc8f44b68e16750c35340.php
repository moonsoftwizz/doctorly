
<?php $__env->startSection('title'); ?> <?php echo e(__('List of Patients')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Patient List <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Patients <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-3">
                                <a href=" <?php echo e(route('patient.create')); ?> ">
                                    <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                        <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('New Patient')); ?>

                                    </button>
                                </a>
                            </div>
                            <div class="col-lg-9 text-right">
                                <form action="">
                                    <div class="form-group d-inline-flex">
                                        <input class="form-control mr-1" type="text" placeholder="Search CPF" name="search_crm" value="<?php echo e($searchCRM); ?>" />
                                        <input class="form-control mr-1" type="text" placeholder="Search Name" name="search_name" value="<?php echo e($search); ?>" />
                                        <button type="submit" value="" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <table class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Id')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Social Name')); ?></th>
                                    <th><?php echo e(__('Birth date')); ?></th>
                                    <th><?php echo e(__('CPF')); ?></th>
                                    <th><?php echo e(__('Phone')); ?></th>
                                    <th><?php echo e(__('Email')); ?></th>
                                    <th><?php echo e(__('Health insurance')); ?></th>
                                    <th><?php echo e(__('Option')); ?></th>
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
                                    $currentpage = $patients->currentPage();
                                ?>

                                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>

                                        <td><?php echo e($patient->id); ?> </td>
                                        <td><?php echo e($patient->full_name); ?></td>
                                        <td><?php echo e($patient->patient['patient_social_name']); ?></td>
                                        <td><?php echo e($patient->patient['patient_dob']); ?></td>
                                        <td><?php echo e($patient->patient['patient_CPF']); ?></td>
                                        <td><?php echo e($patient->mobile); ?></td>
                                        <td><?php echo e($patient->email); ?></td>
                                        <td><?php echo e($patient->patient['patient_health']); ?></td>



                                        
                                               



                                        <td>
                                            
                                                
                                                    
                                                    
                                                    
                                                
                                            
                                            <a href="<?php echo e(url('patient/' . $patient->id . '/edit')); ?>">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                    title="Update Profile">
                                                    <i class="mdi mdi-lead-pencil"></i>
                                                </button>
                                            </a>
                                            <a href=" javascript:void(0)">
                                                <button type="button"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                    title="Deactivate Profile" data-id="<?php echo e($patient->id); ?>"
                                                    id="delete-patient">
                                                    <i class="mdi mdi-trash-can"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="col-md-12 text-center mt-3">
                            <div class="d-flex justify-content-start">
                                Showing <?php echo e($patients->firstItem()); ?> to <?php echo e($patients->lastItem()); ?> of
                                <?php echo e($patients->total()); ?> entries
                            </div>
                            <div class="d-flex justify-content-end">
                                <?php echo e($patients->links()); ?>

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
            $(document).on('click', '#delete-patient', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure want to  delete patient?')) {
                    $.ajax({
                        type: "DELETE",
                        url: 'patient/' + id,
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
                            toastr.error(response.responseJSON.message, {
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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/patient/patients.blade.php ENDPATH**/ ?>