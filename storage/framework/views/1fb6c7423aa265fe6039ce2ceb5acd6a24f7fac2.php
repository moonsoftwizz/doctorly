<?php $__env->startSection('title'); ?> <?php echo e(__('Payment Gateway Key')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- start page title -->
        <?php $__env->startComponent('components.breadcrumb'); ?>
            <?php $__env->slot('title'); ?> Payment Gateway <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
            <?php $__env->slot('li_2'); ?> Payment Gateway <?php $__env->endSlot(); ?>
        <?php echo $__env->renderComponent(); ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Razorpay Information')); ?></blockquote>
                        <form action="<?php echo e(route('payment-key.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" value="<?php echo e($razorpay != null?$razorpay->id:''); ?>" name="id">
                            <div class="col-12 mb-2">
                                <label for="payment_key"> Key</label>
                                <input name="razorpay_key" value="<?php echo e($razorpay!=null? $razorpay->key:''); ?>" class="form-control" placeholder="Enter Razorpay Key">
                                <?php $__errorArgs = ['razorpay_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 mb-2" >
                                <label for="payment_key"> secret</label>
                                <input name="razorpay_secret" value="<?php echo e($razorpay!=null? $razorpay->secret:''); ?>" class="form-control" placeholder="Enter Razorpay Secret">
                                <?php $__errorArgs = ['razorpay_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <input type="hidden" name="gateway_type" value="1">
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Submit')); ?>

                                    </button>
                                </div>
                                <?php if($razorpay): ?>
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)"  class="btn btn-danger" data-id="<?php echo e($razorpay->id); ?>"
                                            id="delete-api">
                                            <?php echo e(__('Delete')); ?>

                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <blockquote><?php echo e(__('Stripe Information')); ?></blockquote>
                        <form action="<?php echo e(route('payment-key.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" value="<?php echo e($stripe != null?$stripe->id:''); ?>" name="id">
                            <div class="col-12 mb-2">
                                <label for="payment_key"> Key</label>
                                <input name="stripe_key" value="<?php echo e($stripe !=null? $stripe->key:''); ?>" class="form-control" placeholder="Enter Stripe Key">
                                <?php $__errorArgs = ['stripe_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="payment_key"> secret</label>
                                <input name="stripe_secrets" value="<?php echo e($stripe!=null? $stripe->secret:''); ?>" class="form-control" placeholder="Enter Stripe Secret">
                                <?php $__errorArgs = ['stripe_secrets'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <input type="hidden" name="gateway_type" value="2">
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Submit')); ?>

                                    </button>
                                </div>
                                <?php if($stripe): ?>
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)"  class="btn btn-danger" data-id="<?php echo e($stripe->id); ?>" id="delete-api">
                                            <?php echo e(__('Delete')); ?>

                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('assets/js/pages/notification.init.js')); ?>"></script>
    <script>
        $(document).on('click', '#delete-api', function() {
            console.log('click');
            var id = $(this).data('id');
            if (confirm('Are you sure want to delete key and scret?')) {
                $.ajax({
                    type: "DELETE",
                    url: 'payment-key/' + id,
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

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/admin/payment-key.blade.php ENDPATH**/ ?>