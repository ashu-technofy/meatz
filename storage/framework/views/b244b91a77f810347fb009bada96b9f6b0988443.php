
<?php $__env->startSection('page'); ?>
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/vendor_components/Ionicons/css/ionicons.css">
<!-- ChartJS -->
<script src="<?php echo e(url('/')); ?>/assets/admin/vendor_components/chart-js/chart.js"></script>
<script src="<?php echo e(url('/')); ?>/assets/admin/js/pages/dashboard2.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="margin:0px">
    <!-- Main content -->
    <section class="content">
        <?php echo $__env->make('Common::admin.home.boxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(1 != 1): ?>
        <?php echo $__env->make('Common::admin.home.monthly_orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-sm-12">
                <div class="row">
                    <?php if(isset($orders)): ?>
                    <?php echo $__env->make('Common::admin.home.orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <?php if(isset($products)): ?>
                    <?php echo $__env->make('Common::admin.home.products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <!-- /.row -->
            
                <div class="col-ms-12">
                    <div class="row">
                        <?php if(isset($stores)): ?>
                        <?php echo $__env->make('Common::admin.home.stores', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>

                        <?php if(isset($counters)): ?>
                        <?php echo $__env->make('Common::admin.home.counter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/home.blade.php ENDPATH**/ ?>