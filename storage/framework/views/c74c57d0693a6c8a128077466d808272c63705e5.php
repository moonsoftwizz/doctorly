<?php $__env->startSection('title'); ?>
    <?php echo e(__('Update Doctor Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
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
                        <?php echo e(__('Update Doctor Details')); ?>

                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('doctor')); ?>"><?php echo e(__('Doctors')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php echo e(__('Update Doctor Details')); ?>

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
                    <a href="<?php echo e(url('doctor')); ?>">
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

                        <form action="<?php echo e(url('doctor/' . $doctor->id)); ?>" method="post" enctype="multipart/form-data">
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
                                                   class="form-control"
                                                   name="full_name" id=""
                                                   value="<?php echo e(old('full_name', $doctor->full_name)); ?>"
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
                                            <label class="control-label"><?php echo e(__(' Sex ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="user_sex">
                                                <option selected><?php echo e(old('user_sex', $doctor->user_sex)); ?></option>
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
                                                   value="<?php echo e(old('doc_CPF', $doctor_info->doc_CPF)); ?>"
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
                                                   value="<?php echo e(old('doc_CPF', $doctor_info->doc_CRM)); ?>"
                                                   placeholder="<?php echo e(__('')); ?>">



                                        </div>

                                        <div class="col-md-4 form-group">
                                            <label class="control-label"><?php echo e(__(' Aadvice ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="doc_Advice">
                                                <option selected><?php echo e(old('doc_Advice', $doctor_info->doc_Advice)); ?></option>
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
                                                <option selected><?php echo e(old('doc_specialty', $doctor_info->doc_specialty)); ?></option>
                                                <option>VET</option>
                                                <option>Doctor</option>
                                                <option>Nurse</option>
                                                <option>General Clinic</option>
                                            </select>

                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Email ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="email" class="form-control"
                                                   name="email" value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->email); ?><?php elseif(old('email')): ?><?php echo e(old('email')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Enter Email')); ?>">
                                            
                                            
                                            
                                            
                                            
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-5">
                                    <blockquote><?php echo e(__('Address')); ?></blockquote>
                                    <div class="row">
                                        <div class="col-md-5 form-group">
                                            <label class="control-label"><?php echo e(__('Zip Code ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="zip_code" value="<?php echo e(old('zip_code', $doctor->zip_code)); ?>"
                                                   placeholder="<?php echo e(__('Zipcode')); ?>">

                                        </div>
                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('Street/ Ave ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="user_address" value="<?php echo e(old('user_address', $doctor->user_address)); ?>"
                                                   placeholder="<?php echo e(__('Address')); ?>">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('City ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control"
                                                   name="city"
                                                   value="<?php echo e(old('city', $doctor->city)); ?>"
                                                   placeholder="<?php echo e(__('city')); ?>">

                                        </div>

                                        <div class="col-md-5 form-group">
                                            <label class="control-label"><?php echo e(__('Phone ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="tel" class="form-control"
                                                   name="mobile"
                                                   value="<?php if($doctor && $doctor_info): ?><?php echo e($doctor->mobile); ?><?php elseif(old('mobile')): ?><?php echo e(old('mobile')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Phone')); ?>">

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('Password ')); ?></label>
                                            <input type="password" class="form-control"
                                                   name="password"
                                                   value="<?php echo e(old('password', $doctor->password)); ?>"
                                                   placeholder="<?php echo e(__('Enter your password')); ?>">

                                        </div>
                                    </div>
                                </div>


                            </div>


                            <!--my code end here-->





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
        <!-- form init -->
        <script src="<?php echo e(URL::asset('assets/js/pages/form-repeater.int.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
        <script>
            // // Profile Photo
            // function triggerClick() {
            //     document.querySelector('#profile_photo').click();
            // }
            //
            // function displayProfile(e) {
            //     if (e.files[0]) {
            //         var reader = new FileReader();
            //         reader.onload = function(e) {
            //             document.querySelector('#profile_display').setAttribute('src', e.target.result);
            //         }
            //         reader.readAsDataURL(e.files[0]);
            //     }
            // }
            // // Time validation
            // var timecount = $('.timecount').length;
            // let cf = 0;
            // let error = 0;
            //
            // function valinput0() {
            //     var startTime = $('input[name="TimeSlot[0][from]"]').val();
            //     var endTime = $('input[name="TimeSlot[0][to]"]').val();
            //     var st = startTime.split(":");
            //     var et = endTime.split(":");
            //     var sst = new Date();
            //     sst.setHours(st[0]);
            //     sst.setMinutes(st[1]);
            //     var eet = new Date();
            //     eet.setHours(et[0]);
            //     eet.setMinutes(et[1]);
            //     if (sst > eet) {
            //         error = 1;
            //         $('.para').html('to value is bigger then from');
            //         $('.para').addClass('d-block');
            //     } else {
            //         error = 0;
            //         $('.para').removeClass('d-block');
            //     }
            // }
            //
            // function change() {
            //     cf++;
            //     setTimeout(function() {
            //         $(document).on('change', `input[name="TimeSlot[${cf}][to]"]`, function() {
            //             validate1();
            //         });
            //     }, 100);
            // }
            //
            // function validate1() {
            //     timecount = $('.timecount').length;
            //     for (let i = 0; i < timecount; i++) {
            //         var startTime = $('input[name="TimeSlot[' + i + '][from]"]').val();
            //         var endTime = $('input[name="TimeSlot[' + i + '][to]"]').val();
            //         currenttime = $(`input[name="TimeSlot[${cf}][from]"]`).val();
            //         currentto = $(`input[name="TimeSlot[${cf}][to]"]`).val();
            //         var st = startTime.split(":");
            //         var et = endTime.split(":");
            //         var ct = currenttime.split(":");
            //         var cft = currentto.split(":");
            //         var sst = new Date();
            //         sst.setHours(st[0]);
            //         sst.setMinutes(st[1]);
            //         var eet = new Date();
            //         eet.setHours(et[0]);
            //         eet.setMinutes(et[1]);
            //         var cct = new Date();
            //         cct.setHours(ct[0]);
            //         cct.setMinutes(ct[1]);
            //         var cff = new Date();
            //         cff.setHours(cft[0]);
            //         cff.setMinutes(cft[1]);
            //         if (cct < cff) {
            //             if (sst < cct && eet > cct) {
            //                 error = 1;
            //                 $('.para').html('Value not accepted');
            //                 $('.para').addClass('d-block');
            //                 break
            //             } else {
            //                 error = 0;
            //                 $('.para').removeClass('d-block');
            //             }
            //         } else {
            //             $('.para').html('to value is bigger then from');
            //             $('.para').addClass('d-block');
            //             break
            //         }
            //     }
            // }
            // // Checkbox value check
            // $('#inlineCheckbox1').on('change', function() {
            //     var inlineCheckbox1 = $('#inlineCheckbox1').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox1').val(inlineCheckbox1);
            // }).change();
            // $('#inlineCheckbox2').on('change', function() {
            //     var inlineCheckbox2 = $('#inlineCheckbox2').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox2').val(inlineCheckbox2);
            // }).change();
            // $('#inlineCheckbox3').on('change', function() {
            //     var inlineCheckbox3 = $('#inlineCheckbox3').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox3').val(inlineCheckbox3);
            // }).change();
            // $('#inlineCheckbox4').on('change', function() {
            //     var inlineCheckbox4 = $('#inlineCheckbox4').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox4').val(inlineCheckbox4);
            // }).change();
            // $('#inlineCheckbox5').on('change', function() {
            //     var inlineCheckbox5 = $('#inlineCheckbox5').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox5').val(inlineCheckbox5);
            // }).change();
            // $('#inlineCheckbox6').on('change', function() {
            //     var inlineCheckbox6 = $('#inlineCheckbox6').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox6').val(inlineCheckbox6);
            // }).change();
            // $('#inlineCheckbox7').on('change', function() {
            //     var inlineCheckbox7 = $('#inlineCheckbox7').is(':checked') ? '1' : '0';
            //     $('#inlineCheckbox7').val(inlineCheckbox7);
            // }).change();
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/doctor/doctor-edit.blade.php ENDPATH**/ ?>