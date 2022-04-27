
<?php $__env->startSection('title'); ?>
    <?php if($doctor && $doctor_info): ?>
        <?php echo e(__('Update Doctor Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Doctor')); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css-bottom'); ?>
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">
                        <?php if($doctor && $doctor_info): ?>
                            <?php echo e(__('Update Doctor Details')); ?>

                        <?php else: ?>
                            <?php echo e(__('Add New Doctor')); ?>

                        <?php endif; ?>
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('doctor')); ?>"><?php echo e(__('Doctors')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php if($doctor && $doctor_info): ?>
                                    <?php echo e(__('Update Doctor Details')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add New Doctor')); ?>

                                <?php endif; ?>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <?php if($doctor && $doctor_info): ?>
                    <?php if($role == 'doctor'): ?>
                        <a href="<?php echo e(url('/')); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                        class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Dashboard')); ?>

                            </button>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('doctor/' . $doctor->id)); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                        class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Profile')); ?>

                            </button>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(url('doctor')); ?> ">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Doctor List')); ?>

                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form id="addtime" action="<?php if($doctor && $doctor_info): ?> <?php echo e(url('doctor/' . $doctor->id)); ?> <?php else: ?> <?php echo e(route('doctor.store')); ?> <?php endif; ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($doctor && $doctor_info): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                        <?php endif; ?>

                        <!-- my code start here-->

                            <div class="row">

                                <div class="col-md-7">
                                    <blockquote><?php echo e(__('Doctor Data')); ?></blockquote>

                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label class="control-label"><?php echo e(__('Doctor Name ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="full_name" id=""
                                                   value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->full_name); ?><?php elseif(old('full_name')): ?><?php echo e(old('full_name')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Enter Doctor Name')); ?>">
                                            <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label"><?php echo e(__(' Sex ')); ?></label>
                                            <select class="form-control" name="user_sex">
                                                <option selected disabled>Choose</option>
                                                <option>Male</option>
                                                <option>Female</option>

                                            </select>


                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <label class="control-label"><?php echo e(__('CPF')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control <?php $__errorArgs = ['doc_CPF'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="doc_CPF" id="" tabindex="1"
                                                   value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->doc_CPF); ?><?php elseif(old('doc_CPF')): ?><?php echo e(old('doc_CPF')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('')); ?>">

                                            <?php $__errorArgs = ['doc_CPF'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label"><?php echo e(__(' CRM ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="doc_CRM" id="" tabindex="1"
                                                   value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->doc_CRM); ?><?php elseif(old('doc_CRM')): ?><?php echo e(old('doc_CRM')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('')); ?>">



                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label class="control-label"><?php echo e(__(' Aadvice ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="doc_Advice">
                                                <option selected disabled>Choose</option>
                                                <option>01 - CRAS</option>
                                                <option>02 - COREN</option>
                                                <option>03 - CRF</option>
                                                <option>04 - CRFA</option>
                                                <option>05 - CREFITO</option>
                                                <option>06 - CRM</option>
                                                <option>07 - CRN</option>
                                                <option>08 - CRO</option>
                                                <option>09 - CRP</option>
                                                <option>10 - OUT</option>
                                                <option>99 - CRMV</option>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Specialty')); ?><span
                                                        class="text-danger">*</span></label>

                                            <select class="form-control" name="doc_specialty">
                                                <option selected disabled>Choose</option>
                                                <option>VET</option>
                                                <option>Doctor</option>
                                                <option>Nurse</option>
                                                <option>General Clinic</option>
                                            </select>

                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Email ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="email" value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->email); ?><?php elseif(old('email')): ?><?php echo e(old('email')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Enter Email')); ?>">
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <blockquote><?php echo e(__('Address')); ?></blockquote>
                                    <div class="row">
                                        <div class="col-md-5 form-group">
                                            <label class="control-label"><?php echo e(__('Zip Code ')); ?></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="zip_code" id=""
                                                   placeholder="<?php echo e(__('Zipcode')); ?>">

                                        </div>
                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('Street/ Ave ')); ?></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="user_address" id=""
                                                   placeholder="<?php echo e(__('Address')); ?>">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('City ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="city"
                                                   value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->user_city); ?><?php elseif(old('user_city')): ?><?php echo e(old('user_city')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('city')); ?>">

                                        </div>

                                        <div class="col-md-5 form-group">
                                            <label class="control-label"><?php echo e(__('Phone ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="tel" class="form-control"
                                                   name="mobile" id="patientMobile" tabindex="4"
                                                   value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->mobile); ?><?php elseif(old('mobile')): ?><?php echo e(old('mobile')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Phone')); ?>">

                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('Password ')); ?></label>
                                            <input type="password" class="form-control"
                                                   name="password"
                                                   placeholder="<?php echo e(__('Enter your password')); ?>">

                                        </div>
                                    </div>


                                </div>


                            </div>


                            <!--my code end here-->
                            <div class="row">
                                <div class="col-md-6">





                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                </div>
                                <div class="col-md-6">




                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($doctor && $doctor_info): ?>
                                            <?php echo e(__('Update Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Doctor')); ?>

                                        <?php endif; ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('assets/libs/jquery-repeater/jquery-repeater.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')); ?>"></script>
        <!-- form init -->
        <script src="<?php echo e(URL::asset('assets/js/pages/form-repeater.int.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/doctor/doctor-details.blade.php ENDPATH**/ ?>