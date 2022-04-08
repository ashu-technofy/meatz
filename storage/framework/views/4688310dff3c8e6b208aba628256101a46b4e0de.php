<div class="col-lg-6">
    <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- Info Boxes Style 2 -->
    <div class="info-box bg-<?php echo e($counter['color']); ?>">
    <span class="info-box-icon push-bottom"><i class="fas <?php echo e($counter['icon']); ?>"></i></span>

        <div class="info-box-content">
            <span class="info-box-text"><?php echo e($counter['title']); ?></span>
            <span class="info-box-number"><?php echo e($counter['count']); ?></span>

            <div class="progress">
                <div class="progress-bar" style="width: <?php echo e($counter['width']); ?>%"></div>
            </div>
            <span class="progress-description">
                <?php echo e(number_format($counter['width'] , 2)); ?>% <?php echo app('translator')->get("Increase in 30 Days"); ?>
            </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<!-- /.col --><?php /**PATH /var/www/html/meatz/Modules/Common/Views/admin/home/counter.blade.php ENDPATH**/ ?>