
<?php $__env->startSection('page'); ?>
<!-- general form elements -->
<form action="<?php echo e(route('admin.notifications')); ?>" method="post" class="action_form" novalidate>
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><?php echo app('translator')->get('Send notification'); ?></h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs langs">
                        <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myname => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo e($loop->iteration == 1 ? 'active' : ''); ?>">
                            <a data-toggle="tab" href="#<?php echo e($myname); ?>"
                                class="<?php echo e($loop->iteration == 1 ? 'active' : ''); ?>">
                                
                                <span><?php echo e(__($lang)); ?></span>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <div class="tab-content">
                        <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang_name => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div id="<?php echo e($lang_name); ?>"
                            class="tab-pane fade <?php echo e($loop->iteration == 1 ? 'in active show' : ''); ?>">
                            <div class="form-group">
                                <label class="col-sm-12" for=""> <?php echo app('translator')->get('Notice title'); ?></label>
                                <div class="col-sm-12">
                                    <input required name="title[<?php echo e($lang_name); ?>]" class="form-control" rows="5"
                                        placeholder=<?php echo app('translator')->get('Notice title'); ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12" for=""> <?php echo app('translator')->get('Notice text'); ?></label>
                                <div class="col-sm-12">
                                    <textarea required name="text[<?php echo e($lang_name); ?>]" class="form-control" rows="5"
                                        placeholder=<?php echo app('translator')->get('Notice text'); ?>></textarea>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> <span><?php echo e(__("Send")); ?></span> <i
                                class="fas fa-save"></i></button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-sm-12 col-md-4">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><?php echo app('translator')->get('Settings'); ?></h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for=""> <?php echo app('translator')->get('notification type'); ?></label>
                            <select name="for" class="form-control selectpicker" title="نوع الاشعار" id="">
                                <option value="all"><?php echo app('translator')->get('all customers'); ?> </option>
                                <option value="android"><?php echo app('translator')->get('android'); ?></option>
                                <option value="ios"><?php echo app('translator')->get('ios'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?php echo app('translator')->get('Notifications'); ?></h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
                <th>#</th>
                <th><?php echo app('translator')->get('Text'); ?></th>
                <th><?php echo app('translator')->get('Created at'); ?></th>
                <th><?php echo app('translator')->get('Resend'); ?></th>
                <th><?php echo app('translator')->get('Delete'); ?></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo e($loop->iteration); ?>

                    </td>
                    <td><?php echo e($row->text); ?></td>
                    <td><?php echo e($row->created_at); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.notifications' , $row->id)); ?>" class="btn btn-primary mlink">
                            <i class="far fa-share-square"></i>
                        </a>
                    </td>
                    <td>
                        <form action="<?php echo e(route("admin.notifications.destroy" , $row->id)); ?>" method="post"
                            class="action_form remove">
                            <?php echo csrf_field(); ?>
                            <?php echo e(method_field('delete')); ?>

                            <button type="submit" class="btn btn-danger removethis">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php echo e($notifications->links()); ?>

    </div>
</div>
<!-- /.card -->
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/notifications.blade.php ENDPATH**/ ?>