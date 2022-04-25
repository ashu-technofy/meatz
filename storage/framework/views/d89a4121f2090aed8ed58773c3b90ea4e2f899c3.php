<!-- Info boxes -->
<div class="row">
    <?php $__currentLoopData = $boxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-12 col-md-6 col-lg-3">
        <a class="mlink" href="<?php echo e($box['url']); ?>">
            <div class="info-box">
                <span class="info-box-icon bg-<?php echo e($box['type']); ?>"><i class="fa <?php echo e($box['icon']); ?>"></i></span>

               <div class="info-box-content">
                    <span class="info-box-number"><?php echo e($box['count']); ?>

                    <?php if(!empty($box['activecount'])): ?>
                    <small class="badge badge-danger" style="border-radius:50%;"><?php echo e($box['activecount']); ?></small>
                    <?php endif; ?>
                    </span>
                    <span class="info-box-text"><?php echo e($box['title']); ?> 
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<!-- /.row --><?php /**PATH /var/www/html/meatz/Modules/Common/Views/admin/home/boxes.blade.php ENDPATH**/ ?>