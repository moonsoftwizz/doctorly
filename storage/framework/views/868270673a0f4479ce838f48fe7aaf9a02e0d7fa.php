
<?php $__env->startSection('title'); ?> <?php echo e(__('List of Patients')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <body data-topbar="dark" data-layout="horizontal">
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?>
        <div class="content">
            <div class="row">

                <div class="col-lg-12">
                    <h2>New Exam</h2>
                </div>

            </div>
            <div class="card">
                <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                    <div class="detail_box">
                        <form action="<?php echo e(route('StoreExam')); ?>" name="examform" class="" method="post">
                            <?php echo csrf_field(); ?>

                            <table class="exam_form">
                                <thead>
                                <tr>
                                    <th>Abbreviation</th>
                                    <th>Exam Name</th>
                                    <th>Category</th>
                                    <th>Team</th>
                                    <th>Destiny</th>
                                    <th>Label Group</th>
                                    <th>Quantity Label</th>
                                    <th>Kit</th>
                                    <th>Support</th>
                                    <th>Price R$</th>

                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td><input class="form-control" type="text" name="abbreviation" /></td>
                                    <td><input class="form-control" type="text" name="name" /></td>
                                    <td><input class="form-control" type="text" name="category" /></td>
                                    <td><input class="form-control" type="text" name="team" /></td>
                                    <td><input class="form-control" type="text" name="destiny" /></td>
                                    <td><input class="form-control" type="text" name="label_group" /></td>
                                    <td><input class="form-control" type="text" name="quantity_label" /></td>
                                    <td><input class="form-control" type="text" name="exam_kit" /></td>
                                    <td><input class="form-control" type="text" name="exam_support" /></td>
                                    <td><input class="form-control" type="text" name="exam_price" /></td>

                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <br>
                            <p><b>REPORT EDITOR</b></p>
                            <p>To insert reference values: ##REFERENCE## <br>To omit an excerpt when printing the report, enclose the text in.
                            </p>
                            <br>
                            <textarea id="summery-ckeditor" name="exam_editor"></textarea>
                            <br>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>

                    </div>
                </div>

            </div>
                </div></div>
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(asset('ckeditor/ckeditor.js')); ?>"></script>
        <script>
            CKEDITOR.replace('summery-ckeditor')
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/exam/registerexam.blade.php ENDPATH**/ ?>