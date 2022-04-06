<?php
    $authed_user = auth()->user() ?? auth('stores')->user();
?>
<header class="main-header" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
    <!-- Logo -->
    <a href="<?php echo e(url('admin')); ?>" class="logo mlink">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b><?php echo e(app_setting('title') ?? 'لوحة التحكم'); ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <?php if($authed_user->role_id): ?>
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php endif; ?>
        <form id="search_form">
            <input type="text" class="form-control" name="keyword" placeholder="<?php echo e(__('Search word')); ?>">
            <i class="fa fa-search"></i>
        </form>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu lang-link">
                    <a href="<?php echo e(route("change_locale")); ?>">
                        <b><?php echo e(app()->getLocale() == 'ar' ? 'EN' : 'عربي'); ?></b>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo e($authed_user->image ??  url('assets/admin/images/user2-160x160.jpg')); ?>"
                            class="user-image rounded" alt="User Image">
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo e($authed_user->image ??  url('assets/admin/images/user2-160x160.jpg')); ?>"
                                class="rounded float-right" alt="User Image">

                            <p>
                                <ul style="list-style-type: none">
                                    <li>
                                        <h3><?php echo e($authed_user->username ?? $authed_user->name->{app()->getLocale()} ?? ''); ?></h3>
                                    </li>
                                    <li>
                                        <span style="color: #999"><?php echo e($authed_user->role->name ?? 'Vendor'); ?></span>
                                    </li>
                                </ul>
                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?php if($authed_user->role_id): ?>
                                <a href="<?php echo e(route('admin.users.edit' , $authed_user->id)); ?>"
                                    class="btn btn-block btn-primary mlink"><?php echo app('translator')->get('My information'); ?></a>
                                <?php else: ?>
                                <a href="<?php echo e(route('admin.stores.edit' , $authed_user->id)); ?>"
                                    class="btn btn-block btn-primary mlink"><?php echo app('translator')->get('My information'); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="pull-left">
                                <a href="<?php echo e(url('logout')); ?>" class="btn btn-block btn-danger"><?php echo app('translator')->get('Logout'); ?></a>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php if($authed_user->role_id): ?>
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope"></i>
                        <?php $messages = \Modules\Contactus\Models\Contactus::where('seen' , null); ?>
                        <?php if($messages->count()): ?>
                        <span class="label label-success messages_count"><?php echo e($messages->count()); ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header"><?php echo e(__("You have :num messages" , ['num' => $messages->count() ])); ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu inner-content-div">
                                <?php $__currentLoopData = $messages->latest()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <!-- start message -->
                                    <a class="mlink" href="<?php echo e(route('admin.contactus.show' , $row->id)); ?>">
                                        <div class="pull-right">
                                            <img src="<?php echo e(url('assets/admin')); ?>/images/user2-160x160.jpg"
                                                class="rounded-circle" alt="User Image">
                                        </div>
                                        <div class="mail-contnet">
                                            <h4>
                                                <?php echo e($row->name); ?>

                                                <small style="position: static;"><i class="fa fa-clock-o"></i> <?php echo e($row->time_ago); ?></small>
                                            </h4>
                                            <span><?php echo e($row->short_message); ?></span>
                                        </div>
                                    </a>
                                </li>
                                <!-- end message -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </li>
                        <li class="footer"><a class="mlink" href="<?php echo e(route('admin.contactus.index')); ?>"><?php echo app('translator')->get('View
                                all'); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <?php 
                        $orders = \Modules\Orders\Models\Order::forStore()->notseen();
                        ?>
                        <?php if($orders->count()): ?>
                        <span class="label label-warning orders_counter"><?php echo e($orders->count()); ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <li class="header"><?php echo app('translator')->get("You have :num new orders" , ['num' => $orders->count()]); ?></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu inner-content-div">
                                <?php $__currentLoopData = $orders->latest()->take(5)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a class="mlink" href="<?php echo e(route('admin.orders.show' , $row->id)); ?>">
                                        <ul style="list-style-type: none">
                                            <li>
                                                <i class="fa fa-users text-aqua"></i> <?php echo e($row->user->username ?? '#'); ?>

                                            </li>
                                            <li>
                                                <i class="fa fa-money"></i>
                                                <?php echo e($row->total ?? '#'); ?> <?php echo app('translator')->get('KD'); ?>
                                            </li>
                                            <li>
                                                <i class="fa fa-clock"></i> <?php echo e($row->created_at); ?>

                                            </li>
                                        </ul>
                                    </a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                        <li class="footer"><a class="mlink"
                                href="<?php echo e(route('admin.orders.index')); ?>"><?php echo app('translator')->get('View all'); ?></a></li>
                    </ul>
                </li>


                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    </ul>
    <!-- Tab panes -->
    <div class="tab-content" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">

        </div>

    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/layout/header.blade.php ENDPATH**/ ?>