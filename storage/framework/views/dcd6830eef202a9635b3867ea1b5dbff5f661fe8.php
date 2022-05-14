<?php $__env->startSection('title'); ?> <?php echo e(__('Book Appointment')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Calender -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/fullcalendar/fullcalendar.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('assets/libs/datatables/datatables.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Book Appointment <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Booked Appointment <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <a href="<?php echo e(url('/appointment/create')); ?>"
                    class="btn btn-primary text-white waves-effect waves-light mb-4">
                    <i class="mdi mdi-arrow-left  font-size-16 align-middle mr-2"></i> <?php echo e(__('Back')); ?>

                </a>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Book Appointment')); ?></blockquote>
                        <form action="<?php echo e(url('appointment-store')); ?>" id="" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php if($role != 'patient'): ?>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Patient ')); ?><span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2 <?php $__errorArgs = ['appointment_for'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="appointment_for" id="patient">
                                            <option disabled selected><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($patient->id); ?>"><?php echo e($patient->first_name); ?>

                                                    <?php echo e($patient->last_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['appointment_for'];
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
                            <?php else: ?>
                                <input type="hidden" name="appointment_for" value="<?php echo e($user->id); ?>">
                            <?php endif; ?>
                            <?php if($role != 'doctor'): ?>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="control-label"><?php echo e(__('Doctor ')); ?><span
                                                class="text-danger">*</span></label>
                                        <select
                                            class="form-control select2 sel-doctor <?php $__errorArgs = ['appointment_with'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="appointment_with" id="doctor">
                                            <option selected disabled><?php echo e(__('Select')); ?></option>
                                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($doctor->id); ?>"
                                                    <?php echo e(old('appointment_with') == $doctor->id ? 'selected' : ''); ?>>
                                                    <?php echo e($doctor->first_name); ?>

                                                    <?php echo e($doctor->last_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['appointment_with'];
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
                            <?php else: ?>
                                <input type="hidden" name="appointment_with" value="<?php echo e($user->id); ?>" id="doctor">
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="control-label"><?php echo e(__('Date ')); ?><span
                                            class="text-danger">*</span></label>
                                    <div class="input-group datepickerdiv">
                                        <input type="text"
                                            class="form-control appointment-date <?php $__errorArgs = ['appointment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="appointment_date" id="datepicker" data-provide="datepicker"
                                            data-date-autoclose="true" autocomplete="off"
                                            <?php echo e(old('appointment_date', date('Y-m-d'))); ?>>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                        <?php $__errorArgs = ['appointment_date'];
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
                            <?php if($role !== 'doctor'): ?>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="" class="d-block"><?php echo e(__("Available Time")); ?><span
                                                class="text-danger">*</span></label>
                                        <div class="btn-group btn-group-toggle availble_time" data-toggle="buttons">


                                        </div>
                                        <?php $__errorArgs = ['available_time'];
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
                                        <?php if($errors->has('available_time')): ?>
                                            <div class="error " role="alert">
                                                <?php echo e($errors->first('available_time')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php elseif($role == 'doctor'): ?>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="" class="d-block"><?php echo e(__("Available Time")); ?> <span
                                                class="text-danger">*</span></label>
                                        <div class="btn-group btn-group-toggle availble_time" data-toggle="buttons">
                                            <?php $__currentLoopData = $doctor_available_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <label class="btn btn-outline-secondary mr-2 ">
                                                    <input type="radio" name="available_time"
                                                        class="available-time <?php $__errorArgs = ['available_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        value="<?php echo e($item->id); ?>">
                                                    <?php echo e($item->from . ' to ' . $item->to); ?>

                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php $__errorArgs = ['available_time'];
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
                                        <?php if($errors->has('available_time')): ?>
                                            <div class="error " role="alert">
                                                <?php echo e($errors->first('available_time')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="" class="d-block"><?php echo e(__("Available Slot")); ?><span
                                            class="text-danger">*</span></label>
                                    <div class="btn-group btn-group-toggle availble_slot d-block" data-toggle="buttons">
                                        <?php $__errorArgs = ['available_slot'];
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
                                        <?php if($errors->has('available_slot')): ?>
                                            <div class="error " role="alert">
                                                <?php echo e($errors->first('available_slot')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Create Appointment')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <!-- Calender Js-->
        <script src="<?php echo e(URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/moment/moment.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/libs/bootstrap-timepicker/bootstrap-timepicker.js')); ?>"></script>
        <!-- Get App url in Javascript file -->
        <script type="text/javascript">
            var aplist_url ="<?php echo e(url('appointmentList')); ?>";
        </script>
        <!-- Init js-->
        <script src="<?php echo e(URL::asset('assets/js/pages/form-advanced.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('assets/js/pages/appointment.js')); ?>"></script>
        <script>
            let datep = $('#datepicker');
            var roles = '<?php echo e($role); ?>';
            if (roles == 'doctor') {
                var day_doctor = '<?php echo e($dayArray); ?>';
                $(".datepickerdiv").prepend(datep);
                $('#datepicker').datepicker({
                    startDate: new Date(),
                    daysOfWeekDisabled: day_doctor
                });
            }
            function days(day) {
                $('#datepicker').remove();
                $(".datepickerdiv").prepend(datep);
                $('#datepicker').datepicker({
                    startDate: new Date(),
                    daysOfWeekDisabled: day
                });
            }
            $('.sel-doctor').change(function(e) {
                e.preventDefault();
                $('.day').removeClass('disabled disabled-date');
                $('.availble_time').empty();
                var doctorId = $(this).val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    type: "post",
                    url: "<?php echo e(route('doctor_by_day_time')); ?>",
                    data: {
                        doctor_id: doctorId,
                        _token: token,
                    },
                    success: function(response) {
                        var res_data = response.data[0];
                        var day = [];
                        if (res_data !== null) {
                            if (res_data.sun == 0)
                                day.push(0);
                            if (res_data.mon == 0)
                                day.push(1);
                            if (res_data.tue == 0)
                                day.push(2);
                            if (res_data.wen == 0)
                                day.push(3);
                            if (res_data.thu == 0)
                                day.push(4);
                            if (res_data.fri == 0)
                                day.push(5);
                            if (res_data.sat == 0)
                                day.push(6);
                            days(day);
                        }
                        var availble_time = response.data[1];
                        $.each(availble_time, function(key, value) {
                            $('.availble_time').append(
                                '<label class="btn btn-outline-secondary mr-2 "><input type="radio" name="available_time" class="available-time <?php $__errorArgs = ['available_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="' +
                                value.id + '" >' + value.from + ' to ' + value.to + '</label>');
                        });
                    },
                    error: function(response) {}
                });
            });
            // datepicker change
            $(document).on('change', '#datepicker', function() {
                $('.availble_slot').empty();
            });
            // doctor available time show
            $(document).on('click', '.available-time', function() {
                $('.availble_slot').empty();
                var token = $("input[name='_token']").val();
                var timeId = $(this).val();
                var dates = $('#datepicker').val();
                var doctorId = $("#doctor").val();
                $.ajax({
                    type: "post",
                    url: "<?php echo e(route('timeBySlot')); ?>",
                    data: {
                        timeId: timeId,
                        _token: token,
                        dates: dates,
                        doctorId: doctorId
                    },
                    success: function(response) {
                        var available_slot = response.data[0];
                        $.each(available_slot, function(key, value) {
                            if (value.appointment.length == 0) {
                                $('.availble_slot').append(
                                    '<label class="btn btn-outline-secondary m-2"><input type="radio" name="available_slot" class="available-slot"  value="' +
                                    value.id + '">' + value.from + ' to ' + value.to +
                                    '</label>');
                            } else {
                                $('.availble_slot').append(
                                    '<label class="btn alert-secondary m-2"><input type="radio" name="available_slot" class="available-slot"  value="' +
                                    value.id + '" disabled>' + value.from + ' to ' + value.to +
                                    '</label>');
                            }
                        });
                    },
                    error: function(error) {
                        console.log(error);
                        toastr.error('Something went wrong!', {
                            timeOut: 10000
                        });
                    }
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/appointment/appointment_create.blade.php ENDPATH**/ ?>