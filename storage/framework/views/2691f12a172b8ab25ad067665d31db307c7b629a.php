<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/')); ?>">
                            <i class="bx bx-home-circle mr-2"></i><?php echo e(__('Dashboard')); ?>

                        </a>
                    </li>
                    <?php if($role == 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Doctors')); ?> <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('doctor')); ?>" class="dropdown-item"><?php echo e(__('List of Doctors')); ?></a>
                                <a href="<?php echo e(route('doctor.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Add New Doctor')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Patients')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('patient')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Patients')); ?></a>
                                <a href="<?php echo e(route('patient.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Add New Patient')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Receptionist')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('receptionist')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Receptionist')); ?></a>
                                <a href="<?php echo e(route('receptionist.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Add New Receptionist')); ?></a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-list-plus mr-2'></i><?php echo e(__('Appointment')); ?> <div
                                        class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a class="dropdown-item" href="<?php echo e(url('pending-appointment')); ?>">
                                    <?php echo e(__('List of Appointment')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('appointment.create')); ?>">
                                    <?php echo e(__('Create Appointment')); ?>

                                </a>
                            </div>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-list-plus mr-2'></i><?php echo e(__('Exam')); ?> <div
                                        class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a class="dropdown-item" href="<?php echo e(route('view_exam')); ?>">
                                    <?php echo e(__('List of Exams')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('add_exam')); ?>">
                                    <?php echo e(__('Add New Exam')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('category')); ?>">
                                    <?php echo e(__('Category')); ?>

                                </a>
                            </div>
                        </li>

                    <?php elseif($role == 'doctor'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('appointment.create')); ?>">
                                <i class="bx bx-calendar-plus mr-2"></i><?php echo e(__('Appointment')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Patients')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('patient')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Patients')); ?></a>
                                <a href="<?php echo e(route('patient.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Add New Patient')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?php echo e(url('receptionist')); ?>">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Receptionist')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-notepad mr-2"></i><?php echo e(__('Prescription')); ?><div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('prescription')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Prescriptions')); ?></a>
                                <a href="<?php echo e(route('prescription.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Create Prescription')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-receipt mr-2"></i><?php echo e(__('Invoices')); ?> <div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('invoice')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Invoices')); ?></a>
                                <a href="<?php echo e(route('invoice.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Create New Invoice')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('pending-appointment')); ?>">
                                <i class='bx bx-list-plus mr-2'></i><?php echo e(__('Appointment List')); ?>

                            </a>
                        </li>
                    <?php elseif($role == 'receptionist'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('appointment.create')); ?>">
                                <i class="bx bx-calendar-plus mr-2"></i><?php echo e(__('Appointment')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('doctor')); ?>">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Doctors')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Patients')); ?> <div
                                    class="arrow-down"></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('patient')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Patients')); ?></a>
                                <a href="<?php echo e(route('patient.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Add New Patient')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('prescription')); ?>">
                                <i class="bx bx-notepad mr-2"></i><?php echo e(__('Prescription')); ?>

                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-receipt mr-2"></i><?php echo e(__('Invoices')); ?><div class="arrow-down">
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topnav-layout">
                                <a href="<?php echo e(url('invoice')); ?>"
                                    class="dropdown-item"><?php echo e(__('List of Invoices')); ?></a>
                                <a href="<?php echo e(route('invoice.create')); ?>"
                                    class="dropdown-item"><?php echo e(__('Create New Invoice')); ?></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('pending-appointment')); ?>">
                                <i class='bx bx-list-plus mr-2'></i><?php echo e(__('Appointment List')); ?>

                            </a>
                        </li>
                    <?php elseif($role == 'patient'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('appointment.create')); ?>">
                                <i class="bx bx-calendar-plus mr-2"></i><?php echo e(__('Appointment')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('doctor')); ?>">
                                <i class="bx bx-user-circle mr-2"></i><?php echo e(__('Doctors')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('prescription-list')); ?>">
                                <i class="bx bx-notepad mr-2"></i><?php echo e(__('Prescription')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('invoice-list')); ?>">
                                <i class="bx bx-receipt mr-2"></i><?php echo e(__('Invoices')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(url('patient-appointment')); ?>">
                                <i class='bx bx-list-plus mr-2'></i><?php echo e(__('Appointment List')); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/layouts/hor-menu.blade.php ENDPATH**/ ?>