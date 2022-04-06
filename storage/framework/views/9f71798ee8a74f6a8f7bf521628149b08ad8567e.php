<div class="col-lg-12 col-xl-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo app('translator')->get('New Orders'); ?></h3>

            <div class="box-tools pull-left">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-responsive no-margin" style="height: 515px">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Created at'); ?></th>
                            <th><?php echo app('translator')->get('Orders count'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><a href="<?php echo e(route('admin.stores.show' , $store->id)); ?>"
                                    class="mlink"><?php echo e($store->name->{app()->getLocale()} ?? $store->id); ?></a></td>
                            <td><?php echo e($store->created_at); ?></td>
                            <td><?php echo e($store->orders()->count() ?? ''); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="<?php echo e(route('admin.stores.index')); ?>" class="mlink btn btn-sm btn-default btn-flat pull-left"><?php echo app('translator')->get('View all'); ?></a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/home/stores.blade.php ENDPATH**/ ?>