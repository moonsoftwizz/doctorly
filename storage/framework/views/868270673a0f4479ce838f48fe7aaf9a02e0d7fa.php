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
                                <br>
                                <br>
                                <p><b>REPORT EDITOR</b></p>
                                <p>To insert reference values: ##REFERENCE## <br>To omit an excerpt when printing the report, enclose the text in.
                                </p>
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-9 text-right">
                                        <div class="form-group d-inline-flex">
                                            <button type="button" class="btn waves-effect waves-light mb-4" data-toggle="modal" data-target="#newParameterModal" data-backdrop="static" data-keyboard="false" style="color: black;background-color: #e3ebf2;">
                                                <i class="bx bx-hash font-size-16 align-middle mr-2"></i> <?php echo e(__('New Parameters')); ?>

                                            </button>
                                        </div>
                                        <div class="form-group d-inline-flex">
                                            <button type="button" class="btn waves-effect waves-light mb-4" data-toggle="modal" data-target="#showTableModal" data-backdrop="static" data-keyboard="false" style="color: black;background-color: #e3ebf2;">
                                                <i class="bx bx-hash font-size-16 align-middle mr-2"></i> <?php echo e(__('Report Parameters')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <textarea id="summery-ckeditor" name="exam_editor"></textarea>
                                <br>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="newParameterModal" tabindex="-1" aria-labelledby="newParameterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content form-group">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD PARAMETERS TO THE REPORT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('StoreExam')); ?>" name="examform" id="save-parameter" method="post" style="padding: 16px;">
                    <?php echo csrf_field(); ?>
                    <table class="new_parameter_form">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Type</th>
                                <th>Abbreviations</th>
                                <th>Formula</th>
                                <th>Size</th>
                                <th>Decimal Places</th>
                                <th>Minimum</th>
                                <th>Maximum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class="form-control" type="text" name="parameter" /></td>
                                <td>
                                    <select name="type" class="form-control" style="width: 110px;">
                                        <option value="text">Text</option>
                                        <option value="numeric">Numeric</option>
                                        <option value="abbreviation">Abbreviation</option>
                                        <option value="formula">Formula</option>
                                        <option value="area">Area</option>
                                        <option value="image">Image</option>
                                    </select>
                                </td>
                                <td><input class="form-control" type="text" name="abbreviations" /></td>
                                <td><input class="form-control" type="text" name="formula" /></td>
                                <td><input class="form-control" type="text" name="size" /></td>
                                <td><input class="form-control" type="text" name="decimal_places" /></td>
                                <td><input class="form-control" type="text" name="minimum" /></td>
                                <td><input class="form-control" type="text" name="maximum" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
    <!--Table Modal -->
    <div class="modal fade" id="showTableModal" tabindex="-1" aria-labelledby="newParameterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content form-group">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report Parameters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="content" style="margin-top:30px;">
                    <div class="row">
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-primary waves-effect waves-light mb-4" data-toggle="modal" data-target="#reportModal" data-backdrop="static" data-keyboard="false">
                                <i class="bx bx-plus font-size-16 align-middle mr-2"></i> <?php echo e(__('Add New Record')); ?>

                            </button>
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
                                                    <th>Id</th>
                                                    <th>Parameter (##NAME##)</th>
                                                    <th>Type</th>
                                                    <th>Unit</th>
                                                    <th>Standard value</th>
                                                    <th>Formula</th>
                                                    <th>size</th>
                                                    <th>Description</th>
                                                    <th>Support Parameter</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $parameter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <th><?php echo e($value->id); ?></th>
                                                    <th><?php echo e($value->parameter); ?></th>
                                                    <th><?php echo e(ucfirst($value->type)); ?></th>
                                                    <th><?php echo e($value->unit); ?></th>
                                                    <th><?php echo e($value->standard_value); ?></th>
                                                    <th><?php echo e($value->formula); ?></th>
                                                    <th><?php echo e($value->size); ?></th>
                                                    <th><?php echo e($value->description); ?></th>
                                                    <th><?php echo e($value->support_parameter); ?></th>
                                                    <th>
                                                        <button type="button" value="<?php echo e($value->id); ?>"
                                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0 updateParameter"
                                                                title="Update Parameter" data-backdrop="static" data-keyboard="false">
                                                            <i class="mdi mdi-lead-pencil"></i>
                                                        </button>
                                                        <button type="button" onclick="deleteParameter(<?php echo e($value->id); ?>)"
                                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"
                                                                title="Delete Parameter" data-backdrop="static" data-keyboard="false">
                                                            <i class="mdi mdi-trash-can"></i>
                                                        </button>
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
            </div>
        </div>
    </div>
    <!-- end row -->
    <!-- Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Include</h5>
                    <button type="button" onclick="closeModel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="reportParameterForm" method="POST">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="hiddenId" name="id">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Parameter (##NAME##)</label>
                                    <div  class="col-md-4">
                                        <input name="parameter" id="parameter" type="text" placeholder="Enter parameter" class="form-control" required="">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Type</label>
                                    <div  class="col-md-4">
                                        <select name="type" id="type" class="form-control" style="width: 110px;">
                                            <option value="text">Text</option>
                                            <option value="numeric">Numeric</option>
                                            <option value="abbreviation">Abbreviation</option>
                                            <option value="formula">Formula</option>
                                            <option value="area">Area</option>
                                            <option value="image">Image</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Unit</label>
                                    <div  class="col-md-4">
                                        <input name="unit" id="unit" type="text" placeholder="Enter unit" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Possible Abbreviations (abbreviations between ,)</label>
                                    <div  class="col-md-4">
                                        <input name="abbreviations" id="abbreviations" type="text" placeholder="Enter possible abbreviations" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Standard value</label>
                                    <div  class="col-md-4">
                                        <input name="standard_value" id="standard_value" type="text" placeholder="Enter standard value" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Formula</label>
                                    <div  class="col-md-4">
                                        <input name="formula" id="formula" type="text" placeholder="Enter formula" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Size</label>
                                    <div  class="col-md-4">
                                        <input name="size" id="size" type="text" placeholder="Enter size" class="form-control">
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Decimal Places</label>
                                    <div  class="col-md-4">
                                        <input name="decimal_places" id="decimal_places" type="text" placeholder="Enter decimal places" class="form-control">
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Decimal Mask</label>
                                    <div  class="col-md-4">
                                        <select name="decimal_mask" id="decimal_mask" class="form-control" style="width: 110px;">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Minimum Value</label>
                                    <div  class="col-md-4">
                                        <input name="minimum" id="minimum" type="text" placeholder="Enter minimum value" class="form-control">
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Maximum Value</label>
                                    <div  class="col-md-4">
                                        <input name="maximum" id="maximum" type="text" placeholder="Enter maximum value" class="form-control">
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Block recording when out of bounds</label>
                                    <div  class="col-md-4">
                                        <select name="block_recording" id="block_recording" class="form-control" style="width: 110px;">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Mandatory Parameter</label>
                                    <div  class="col-md-4">
                                        <select name="mandatory_parameter" id="mandatory_parameter" class="form-control" style="width: 110px;">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Imp. Ruler</label>
                                    <div  class="col-md-4">
                                        <select name="imp_ruler" id="imp_ruler" class="form-control" style="width: 110px;">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Previous Imp.</label>
                                    <div  class="col-md-4">
                                        <select name="previous_imp" id="previous_imp" class="form-control" style="width: 110px;">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Description</label>
                                    <div  class="col-md-4">
                                        <input name="description" id="description" type="text" placeholder="Enter description" class="form-control">
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Reference Value</label>
                                    <div  class="col-md-4">
                                        <textarea id="reference_value" id="reference_value" name="reference_value" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Support Parameter</label>
                                    <div  class="col-md-4">
                                        <input name="support_parameter" id="support_parameter" type="text" placeholder="Enter support parameter" class="form-control">
                                    </div>
                                </div>
                                <div  class="row mb-3">
                                    <label  class="col-md-8 col-form-label">Evolutionary Report Parameter</label>
                                    <div  class="col-md-4">
                                        <select name="evolutionary_report_parameter" id="evolutionary_report_parameter" class="form-control" style="width: 110px;">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="closeModel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary saveChange">Save changes</button>
                        <button type="submit" class="btn btn-primary updateChange" style="display: none;">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('ckeditor/ckeditor.js')); ?>"></script>
    <script>
    CKEDITOR.replace('summery-ckeditor');
    $("#save-parameter").on("submit", function(e) {
        e.preventDefault();
        var form_data = $(this);
        
        $.ajax({
            type: "POST",
            url: 'store-parameter',
            data: form_data.serialize(),
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
    });
    $("#reportParameterForm").on("submit", function(e) {
        e.preventDefault();
        var form_data = $(this);
        $.ajax({
            type: "POST",
            url: 'store-parameter',
            data: form_data.serialize(),
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
    });
    $(".updateParameter").on("click", function (e) {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: 'parameter/' + id,
            beforeSend: function() {
                $('#pageloader').show()
            },
            success: function(response) {
                $.each(response.data, function(key, value) {
                    $("#hiddenId").val(value.id);
                    $("#parameter").val(value.parameter);
                    $("#type").val(value.type);
                    $("#unit").val(value.unit);
                    $("#abbreviations").val(value.abbreviations);
                    $("#standard_value").val(value.standard_value);
                    $("#formula").val(value.formula);
                    $("#size").val(value.size);
                    $("#decimal_places").val(value.decimal_places);
                    $("#decimal_mask").val(value.decimal_mask);
                    $("#minimum").val(value.minimum);
                    $("#maximum").val(value.maximum);
                    $("#block_recording").val(value.block_recording);
                    $("#mandatory_parameter").val(value.mandatory_parameter);
                    $("#imp_ruler").val(value.imp_ruler);
                    $("#previous_imp").val(value.previous_imp);
                    $("#description").val(value.description);
                    $("#reference_value").val(value.reference_value);
                    $("#support_parameter").val(value.support_parameter);
                    $("#evolutionary_report_parameter").val(value.evolutionary_report_parameter);
                    $(".saveChange").css({"display": "none"});
                    $(".updateChange").removeAttr("style");
                });
                $("#reportModal").modal('show');
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
    });
    function deleteParameter(id) {
        if (confirm('Are you sure want to delete parameter?')) {
            $.ajax({
                type: "DELETE",
                url: 'parameter/' + id,
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
    }
    function closeModel() {
        $("#parameter").val('');
        $("#type").val('text');
        $("#unit").val('');
        $("#abbreviations").val('');
        $("#standard_value").val('');
        $("#formula").val('');
        $("#size").val('');
        $("#decimal_places").val('');
        $("#decimal_mask").val('0');
        $("#minimum").val('');
        $("#maximum").val('');
        $("#block_recording").val('0');
        $("#mandatory_parameter").val('0');
        $("#imp_ruler").val('1');
        $("#previous_imp").val('1');
        $("#description").val('');
        $("#reference_value").val('');
        $("#support_parameter").val('');
        $("#evolutionary_report_parameter").val('1');
        $(".saveChange").removeAttr("style");
        $(".updateChange").css({"display": "none"});
    }
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/exam/registerexam.blade.php ENDPATH**/ ?>