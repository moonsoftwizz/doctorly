
<?php $__env->startSection('title'); ?>
    <?php if($patient ): ?>
        <?php echo e(__('Update Patient Details')); ?>

    <?php else: ?>
        <?php echo e(__('Add New Patient')); ?>

    <?php endif; ?>
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
                        <?php if($patient && $patient_info && $medical_info): ?>
                            <?php echo e(__('Update Patient Details')); ?>

                        <?php else: ?>
                            <?php echo e(__('Add New Patient')); ?>

                        <?php endif; ?>
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(url('patient')); ?>"><?php echo e(__('Patients')); ?></a></li>
                            <li class="breadcrumb-item active">
                                <?php if($patient): ?>
                                    <?php echo e(__('Update Patient Details')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Add New Patient')); ?>

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
                <?php if($patient && $patient_info && $medical_info): ?>
                    <?php if($role == 'patient'): ?>
                        <a href="<?php echo e(url('/')); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Dashboard')); ?>

                            </button>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('patient/' . $patient->id)); ?>">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                                <i
                                    class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Profile')); ?>

                            </button>
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(url('patient')); ?>">
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4">
                            <i
                                class="bx bx-arrow-back font-size-16 align-middle mr-2"></i><?php echo e(__('Back to Patient List')); ?>

                        </button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <form action="<?php if($patient ): ?> <?php echo e(url('patient/' . $patient->id)); ?> <?php else: ?> <?php echo e(route('patient.store')); ?> <?php endif; ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if($patient ): ?>
                                <input type="hidden" name="_method" value="PATCH" />
                            <?php endif; ?>


                        <!-- my code start here-->

                            <div class="row">

                                <div class="col-md-7">
                                    <blockquote><?php echo e(__('Patient Data')); ?></blockquote>

                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label class="control-label"><?php echo e(__('Patient Name ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="full_name" id=""
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient->full_name); ?><?php elseif(old('full_name')): ?><?php echo e(old('full_name')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Enter Patient Name')); ?>">
                                            
                                            
                                            
                                            
                                            
                                        </div>

                                        <div class="col-md-4">

                                            <label class="control-label"><?php echo e(__(' Sex ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <select class="form-control" name="user_sex">

                                                <option selected disabled><?php echo e(__('-- Select Gender --')); ?> </option>
                                                <option value="Male" <?php if(($patient_info && $patient->user_sex == 'Male') || old('user_sex') == 'Male'): ?> selected <?php endif; ?>><?php echo e(__('Male')); ?></option>
                                                <option value="Female" <?php if(($patient_info && $patient->user_sex == 'Female') || old('user_sex') == 'Female'): ?> selected <?php endif; ?>><?php echo e(__('Female')); ?>

                                                </option>

                                            </select>


                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-3 form-group">
                                            <label class="control-label"><?php echo e(__('Birth Date')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="date"
                                                   class="form-control <?php $__errorArgs = ['patient_dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="patient_dob" id="" tabindex="1"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_dob); ?><?php elseif(old('patient_dob')): ?><?php echo e(old('patient_dob')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('')); ?>">

                                            
                                            
                                                    
                                                
                                            

                                        </div>



                                        <div class="col-md-3 form-group">
                                            <label class="control-label"><?php echo e(__(' Age ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="patient_Age" id="" tabindex="1"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_Age); ?><?php elseif(old('patient_Age')): ?><?php echo e(old('patient_Age')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('')); ?>">

                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="control-label"><?php echo e(__(' RG ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   name="patient_rg" id="" tabindex="1"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_rg); ?><?php elseif(old('patient_rg')): ?><?php echo e(old('patient_rg')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('')); ?>">

                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label class="control-label"><?php echo e(__('CPF')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control <?php $__errorArgs = ['patient_CPF'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="patient_CPF" id="" tabindex="1"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_CPF); ?><?php elseif(old('patient_CPF')): ?><?php echo e(old('patient_CPF')); ?><?php endif; ?>"
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

                                        <div class="col-md-6 form-group">
                                            <label class="control-label"><?php echo e(__('Responsible')); ?><span
                                                        class="text-danger">*</span></label>

                                            <input type="text" class="form-control"
                                                   name="patient_responsible"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_responsible); ?><?php elseif(old('patient_responsible')): ?><?php echo e(old('patient_responsible')); ?><?php endif; ?>"

                                                   placeholder="<?php echo e(__('')); ?>" />

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
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient->zip_code); ?><?php elseif(old('zip_code')): ?><?php echo e(old('zip_code')); ?><?php endif; ?>"
                                                   name="zip_code" id=""
                                                   placeholder="<?php echo e(__('Zipcode')); ?>">

                                        </div>
                                        <div class="col-md-7 form-group">
                                            <label class="control-label"><?php echo e(__('Street/ Ave ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient->user_address); ?><?php elseif(old('user_address')): ?><?php echo e(old('user_address')); ?><?php endif; ?>"
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
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient->city); ?><?php elseif(old('city')): ?><?php echo e(old('city')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('city')); ?>">

                                        </div>

                                        <div class="col-md-5 form-group">
                                            <label class="control-label"><?php echo e(__('Phone ')); ?><span
                                                        class="text-danger">*</span></label>
                                            <input type="tel" class="form-control"
                                                   name="mobile" tabindex="4"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient->mobile); ?><?php elseif(old('mobile')): ?><?php echo e(old('mobile')); ?><?php endif; ?>"
                                                   placeholder="<?php echo e(__('Phone')); ?>">

                                        </div>

                                    </div>
                                    <div class="row">

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
                                                   name="email" id="email"
                                                   value="<?php if($patient && $patient_info): ?><?php echo e($patient->email); ?><?php elseif(old('email')): ?><?php echo e(old('email')); ?><?php endif; ?>"
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

                                        <div class="col-md-6 form-group">
                                                <label class="control-label"><?php echo e(__('Password ')); ?></label>
                                                <input type="password" class="form-control"
                                                       name="password"
                                                       value="<?php if($patient && $patient_info): ?><?php echo e($patient->password); ?><?php elseif(old('password')): ?><?php echo e(old('password')); ?><?php endif; ?>"
                                                       placeholder="<?php echo e(__('Enter your password')); ?>">

                                         </div>


                                    </div>
                                </div>


                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label class="control-label"><?php echo e(__('Health Insurance')); ?><span
                                                class="text-danger">*</span></label>

                                    <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="patient_health" value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_health); ?><?php elseif(old('patient_health')): ?><?php echo e(old('patient_health')); ?><?php endif; ?>"
                                           placeholder="<?php echo e(__('')); ?>">

                                </div>

                                <div class="col-md-2 form-group">
                                    <label class="control-label"><?php echo e(__('Company')); ?><span
                                                class="text-danger">*</span></label>

                                    <input type="text" class="form-control <?php $__errorArgs = ['patient_company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="patient_company" value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_company); ?><?php elseif(old('patient_company')): ?><?php echo e(old('patient_company')); ?><?php endif; ?>"
                                           placeholder="<?php echo e(__('')); ?>">

                                </div>


                                <div class="col-md-2 form-group">
                                    <label class="control-label"><?php echo e(__('Enrollment')); ?><span
                                                class="text-danger">*</span></label>

                                    <input type="text" class="form-control <?php $__errorArgs = ['patient_enrollment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="patient_enrollment" value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_enrollment); ?><?php elseif(old('patient_enrollment')): ?><?php echo e(old('patient_enrollment')); ?><?php endif; ?>"
                                           placeholder="<?php echo e(__('')); ?>">

                                </div>

                                <div class="col-md-2 form-group">
                                    <label class="control-label"><?php echo e(__('Plan')); ?><span
                                                class="text-danger">*</span></label>

                                    <input type="text" class="form-control <?php $__errorArgs = ['patient_plan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="patient_plan" value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_plan); ?><?php elseif(old('patient_plan')): ?><?php echo e(old('patient_plan')); ?><?php endif; ?>"
                                           placeholder="<?php echo e(__('')); ?>">

                                </div>

                                <div class="col-md-2 form-group">
                                    <label class="control-label"><?php echo e(__('Observation')); ?><span
                                                class="text-danger">*</span></label>

                                    <input type="text" class="form-control <?php $__errorArgs = ['patient_observation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="patient_observation" value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_observation); ?><?php elseif(old('patient_observation')): ?><?php echo e(old('patient_observation')); ?><?php endif; ?>"
                                           placeholder="<?php echo e(__('')); ?>">

                                </div>

                                <div class="col-md-2 form-group">
                                    <label class="control-label"><?php echo e(__('Social Name')); ?><span
                                                class="text-danger">*</span></label>

                                    <input type="text" class="form-control <?php $__errorArgs = ['patient_social_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="patient_social_name" value="<?php if($patient && $patient_info): ?><?php echo e($patient_info->patient_social_name); ?><?php elseif(old('patient_social_name')): ?><?php echo e(old('patient_social_name')); ?><?php endif; ?>"
                                           placeholder="<?php echo e(__('')); ?>">

                                </div>

                            </div>


                            <!--my code end here-->


                            
                                
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                                
                                                
                                                
                                            
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                
                                
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                            
                                                
                                                
                                                
                                            
                                                
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                
                            
                            
                            
                                
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                            
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                
                                
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                                
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                    
                                        
                                            
                                                    
                                            
                                                
                                                
                                                
                                                    
                                                
                                                    
                                                
                                                
                                            
                                            
                                                
                                                    
                                                
                                            
                                        
                                    
                                
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php if($patient && $patient_info): ?>
                                            <?php echo e(__('Update Patient Details')); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Add New Patient')); ?>

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
        <script>
            // Profile Photo
            function triggerClick() {
                document.querySelector('#profile_photo').click();
            }

            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/patient/patient-details.blade.php ENDPATH**/ ?>