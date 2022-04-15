<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo e(url('/')); ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo e(URL::asset('assets/images/logo-dark.png')); ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(URL::asset('assets/images/logo-dark1.png')); ?>" alt="" height="17">
                    </span>
                </a>
                <a href="<?php echo e(url('/')); ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo e(URL::asset('assets/images/logo-light.png')); ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo e(URL::asset('assets/images/logo-light1.png')); ?>" alt="" height="19">
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo e(__("Search ...")); ?>"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- App Search-->
        </div>
        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="<?php echo e(__("Search ...")); ?>"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="bx bx-bell bx-tada"></i>
                    <span class="badge badge-danger badge-pill"><?php echo e($Cnotification_count->count()); ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?php echo e(__("Notifications")); ?></h6>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo e(url('/notification-list')); ?>" class="small"> <?php echo e(__("View All")); ?></a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar class="notification-list-scroll overflow-auto" style="max-height: 230px;">
                        <?php $__empty_1 = true; $__currentLoopData = $Cnotification_count; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="/notification/<?php echo e($item->id); ?>" class="text-reset notification-item bg-light ">
                                <div class="media">
                                    <img src="<?php if($user->profile_photo != ''): ?><?php echo e(URL::asset('storage/images/users/' . $user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/noImage.png')); ?><?php endif; ?>"
                                        class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-1"><?php echo e($item->user->first_name .' '.$item->user->last_name); ?></h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1"><?php echo e($item->title); ?></p>
                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?php echo e($item->created_at->diffForHumans()); ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="<?php echo e(url('/notification-list')); ?>">
                            <i class="mdi mdi-arrow-right-circle mr-1"></i> <?php echo e(__("View More..")); ?>

                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                    src="<?php if($user->profile_photo != ''): ?><?php echo e(URL::asset('storage/images/users/' . $user->profile_photo)); ?><?php else: ?><?php echo e(URL::asset('assets/images/users/noImage.png')); ?><?php endif; ?>"
                    alt="Avatar">
                    <span class="d-none d-xl-inline-block ml-1"><?php echo e($user->first_name); ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <?php if($role == 'doctor'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-view')); ?>"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i> <?php echo e(__("Profile")); ?></a>
                    <?php elseif($role == 'patient'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-view')); ?>"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i> <?php echo e(__("Profile")); ?></a>
                    <?php elseif($role == 'receptionist'): ?>
                        <a class="dropdown-item" href="<?php echo e(url('profile-view')); ?>"><i
                                class="bx bx-user font-size-16 align-middle mr-1"></i> <?php echo e(__("Profile")); ?></a>
                    <?php elseif($role == 'admin'): ?>
                    <a class="dropdown-item" href="<?php echo e(url('profile-edit')); ?>"><i
                        class="bx bx-user font-size-16 align-middle mr-1"></i> <?php echo e(__("Change Profile")); ?></a>
                    <a class="dropdown-item" href="<?php echo e(url('payment-key')); ?>"><i
                        class="bx bx-key font-size-16 align-middle mr-1"></i> <?php echo e(__("Add Api Key")); ?></a>
                    <?php endif; ?>
                    <a class="dropdown-item d-block" href="<?php echo e(url('change-password')); ?>"><i
                            class="bx bx-wrench font-size-16 align-middle mr-1"></i> <?php echo e(__("Change Password")); ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                        <?php echo e(__('Logout')); ?> </a>
                    <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect ">
                    <i class="bx bx-cog bx-spin"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\xampp3\htdocs\doctorly\resources\views/layouts/top-hor.blade.php ENDPATH**/ ?>