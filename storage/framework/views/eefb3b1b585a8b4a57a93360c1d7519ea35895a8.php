<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="image float-right">
                <img src="<?php echo e(auth()->user()->image ?? url('assets/admin/images/user2-160x160.jpg')); ?>" class="rounded"
                    alt="User Image">
            </div>
            <div class="info float-right">
                <p><?php echo e(auth()->user()->username ?? auth()->user()->name ?? 'Admin'); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                                class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a class="mlink" href="<?php echo e(url("admin")); ?>">
                    <i class="fa fa-home"></i>
                    <span><?php echo app('translator')->get('Home'); ?></span>
                </a>
            </li>
       
            <?php $__currentLoopData = sidebar(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($group['link'])): ?>
            <li class="treeview">
                <a class="mlink" href="<?php echo e(route("admin.".$group['link'])); ?>">
                    <i class="fa fa-dashboard"></i>
                    <span><?php echo e($group['title']); ?></span>
                </a>
            </li>
            <?php else: ?>
            <label class='side-title'><?php echo e($group['title']); ?></label>
            <?php $__currentLoopData = $group['links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="treeview">
                <?php if(isset($row['query'])): ?>
                <a href="<?php echo e(route('admin.'.$row['link'] , $row['query'])); ?>" class="mlink">
                    <?php else: ?>
                    <a href="<?php echo e($row['link'] != '#' ? route('admin.'.$row['link']) : '#'); ?>"
                        class="<?php echo e($row['link'] != '#' ? 'mlink' : ''); ?>">
                        <?php endif; ?>
                        <i class="<?php echo e($row['icon'] ?? ''); ?>"></i>
                        <span><?php echo e($row['title']); ?></span>
                        <?php if(isset($row['childs'])): ?>
                        <span class="pull-left-container">
                            <i class="fa fa-angle-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> pull-left"></i>
                        </span>
                        <?php endif; ?>
                        <?php if(isset($row['count'])): ?>
                        <span class="pull-left-container">
                        <small class="label pull-left  <?php echo e($row['count']['count'] ? 'bg-red' : ''); ?> <?php echo e($row['count']['class']); ?>">
                            <?php echo e($row['count']['count'] == 0 ? '' : $row['count']['count']); ?>

                        </small>
                        </span>
                        <?php endif; ?>

                    </a>
                    <?php if(isset($row['childs'])): ?>
                    <ul class="treeview-menu">
                        <?php $__currentLoopData = $row['childs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(isset($child['query']) ? route('admin.'.$child['link'] , $child['query']) : route('admin.'.$child['link'])); ?>"
                                class="mlink">
                                <i class="far fa-circle"></i>
                                <?php echo e($child['title']); ?>

                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </section>
    <!-- /.sidebar -->
    <div class="sidebar-footer">
        <!-- item-->
        <a href="<?php echo e(route('admin.settings.app')); ?>" class="mlink link" data-toggle="tooltip" title=""
            data-original-title="Settings"><i class="fa fa-cog fa-spin"></i></a>
        <!-- item-->
        <a href="<?php echo e(route('admin.contactus.index')); ?>" class="mlink link" data-toggle="tooltip" title=""
            data-original-title="Email"><i class="fa fa-envelope"></i></a>
        <!-- item-->
        <a href="<?php echo e(route('logout')); ?>" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i
                class="fa fa-power-off"></i></a>
    </div>
</aside><?php /**PATH /var/www/html/meatz/Modules/Common/Views/admin/layout/side.blade.php ENDPATH**/ ?>