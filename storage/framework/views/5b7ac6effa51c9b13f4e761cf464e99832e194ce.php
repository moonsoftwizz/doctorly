<?php $__env->startSection('title'); ?> <?php echo e(__('Patient Profile')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <?php echo e(__('Patient Profile')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('patient')); ?>"><?php echo e(__('Patients')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Patient Profile')); ?>

                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary"><?php echo e(__('Patient Information')); ?></h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?php echo e(URL::asset('assets/images/profile-img.png')); ?>" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <img src="<?php if($patient->profile_photo != null): ?><?php echo e(URL::asset('storage/images/users/' . $patient->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/noImage.png')); ?><?php endif; ?>" alt="<?php echo e($patient->first_name); ?>"
                                        class="img-thumbnail rounded-circle">
                                </div>
                                <h5 class="font-size-15 text-truncate"> <?php echo e($patient->first_name); ?>

                                    <?php echo e($patient->last_name); ?></h5>
                            </div>
                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-12"><?php echo e(__('Last Login :')); ?></h5>
                                            <p class="text-muted mb-0"> <?php echo e($patient->last_login); ?> </p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="<?php echo e(url('patient/' . $patient->id . '/edit')); ?>"
                                            class="btn btn-primary waves-effect waves-light btn-sm"><?php echo e(__('Edit Profile ')); ?><i
                                                class="mdi mdi-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><?php echo e(__('Personal Information')); ?></h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Full Name:')); ?></th>
                                        <td><?php echo e($patient->first_name); ?> <?php echo e($patient->last_name); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Contact No:')); ?></th>
                                        <td> <?php echo e($patient->mobile); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Email:')); ?></th>
                                        <td> <?php echo e($patient->email); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Age:')); ?></th>
                                        <td> <?php echo e($patient_info->age); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Gender:')); ?></th>
                                        <td> <?php echo e($patient_info->gender); ?> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo e(__('Address:')); ?></th>
                                        <td> <?php echo e($patient_info->address); ?> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium"><?php echo e(__('Appointments')); ?></p>
                                        <h4 class="mb-0"><?php echo e(number_format($data['total_appointment'])); ?></h4>
                                    </div>
                                    <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-check-circle font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium"><?php echo e(__('Pending Bills')); ?></p>
                                        <h4 class="mb-0"><?php echo e(number_format($data['pending_bill'])); ?></h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-hourglass font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium"><?php echo e(__('Total Bill')); ?></p>
                                        <h4 class="mb-0">$<?php echo e(number_format($data['revenue'], 2)); ?></h4>
                                    </div>
                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-package font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Medical_info" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Medical Information')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#AppointmentList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Appointment List')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#PrescriptionList" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Prescription List')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Invoices" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block"><?php echo e(__('Invoices')); ?></span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="Medical_info" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Height')); ?></th>
                                                <td> <?php echo e($medical_Info->height); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Weight')); ?></th>
                                                <td> <?php echo e($medical_Info->weight); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Blood Group')); ?></th>
                                                <td> <?php echo e($medical_Info->b_group); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Blood Pressure')); ?></th>
                                                <td> <?php echo e($medical_Info->b_pressure); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Pulse')); ?></th>
                                                <td> <?php echo e($medical_Info->pulse); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Respiration')); ?></th>
                                                <td> <?php echo e($medical_Info->respiration); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Allergy')); ?></th>
                                                <td> <?php echo e($medical_Info->allergy); ?> </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><?php echo e(__('Diet')); ?></th>
                                                <td> <?php echo e($medical_Info->diet); ?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="AppointmentList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Doctor Name')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
                                        </tr>
                                    </thead>
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
                                        $currentpage = $invoices->currentPage();
                                    ?>
                                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?></td>
                                            <td><?php echo e($item->doctor->first_name); ?> <?php echo e($item->doctor->last_name); ?></td>
                                            <td><?php echo e($item->appointment_date); ?></td>
                                            <td><?php echo e($item->timeSlot->from . ' to ' . $item->timeSlot->to); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing <?php echo e($appointments->firstItem()); ?> to <?php echo e($appointments->lastItem()); ?> of
                                        <?php echo e($appointments->total()); ?> entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($appointments->links()); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="PrescriptionList" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Doctor Name')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
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
                                            $currentpage = $prescriptions->currentPage();
                                        ?>
                                        <?php $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?></td>
                                                <td><?php echo e($item->doctor->first_name); ?> <?php echo e($item->doctor->last_name); ?>

                                                </td>
                                                <td><?php echo e(date('d-m-Y')); ?></td>
                                                <td>
                                                    <a href="<?php echo e(url('prescription/' . $item->id)); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            <?php echo e(__('View')); ?>

                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing <?php echo e($prescriptions->firstItem()); ?> to <?php echo e($prescriptions->lastItem()); ?>

                                        of <?php echo e($prescriptions->total()); ?> entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($prescriptions->links()); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Invoices" role="tabpanel">
                                <table class="table table-bordered dt-responsive nowrap "
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Sr. No')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Status')); ?></th>
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
                                            $currentpage = $invoices->currentPage();
                                        ?>
                                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1 + $per_page * ($currentpage - 1)); ?></td>
                                                <td><?php echo e(date('d-m-Y')); ?></td>
                                                <td><?php echo e($item->payment_status); ?></td>
                                                <td>
                                                    <a href="<?php echo e(url('invoice/' . $item->id)); ?>">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                            <?php echo e(__('View')); ?>

                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center mt-3">
                                    <div class="d-flex justify-content-start">
                                        Showing <?php echo e($invoices->firstItem()); ?> to <?php echo e($invoices->lastItem()); ?> of
                                        <?php echo e($invoices->total()); ?> entries
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <?php echo e($invoices->links()); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- flot plugins -->
        <script src="<?php echo e(URL::asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
        <!-- Plugins js -->
        <script src="<?php echo e(URL::asset('assets/libs/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/pdfmake/pdfmake.min.js')); ?>"></script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('assets/js/pages/profile.init.js')); ?>"></script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/patient/patient-profile.blade.php ENDPATH**/ ?>