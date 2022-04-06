<?php $__env->startSection('title' , __('Sorry Page Not Found')); ?>
<?php $__env->startSection('page'); ?>
<!-- content -->
<section class="error-sec">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12 text-center">
        <img src="<?php echo e(url('assets/web')); ?>/img/404-img.png">
          <h1 class="title text-center mt-5">
            <?php echo e(__('Sorry Page Not Found')); ?>

          </h1>
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/meatz/Modules/Common/Views/404.blade.php ENDPATH**/ ?>