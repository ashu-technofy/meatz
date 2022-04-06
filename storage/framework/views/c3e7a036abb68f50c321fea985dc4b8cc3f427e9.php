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
                            <th><?php echo app('translator')->get('ID'); ?></th>
                            <th><?php echo app('translator')->get('Client'); ?></th>
                            <th><?php echo app('translator')->get('Total'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Created at'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                        class="mlink"><?php echo e($order->id); ?></a></td>
                                <td><?php echo e($order->myuser->username ?? ''); ?></td>
                                <td><?php echo e($order->total ?? ''); ?></td>
                                <td><?php echo $order->badge; ?></td>
                                <td><?php echo e($order->created_at); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="<?php echo e(route('admin.orders.index')); ?>"
                class="mlink btn btn-sm btn-default btn-flat pull-left"><?php echo app('translator')->get('View all'); ?></a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>
<?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/home/orders.blade.php ENDPATH**/ ?>