
<script>

    if (typeof fromajax === 'undefined') {
        localStorage.setItem('route', window.location);
        window.location = "<?php echo e(route('admin.load')); ?>";
    } else {
        localStorage.setItem('route', 0);
    }
    $.get("<?php echo e(route('admin.add_actions')); ?>" , {
        'title' : "<?php echo e($title); ?>" ,
        "url"  : "<?php echo e(request()->url()); ?>" ,
        "name" : "<?php echo e($model->name->ar ?? $model->name ?? ''); ?>"
        });

</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo app('translator')->get('Dashboard'); ?>
        <small><?php echo e(app_setting('title')); ?></small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="mlink" href="<?php echo e(url('/admin')); ?>"><i class="fa fa-dashboard"></i>
                <?php echo app('translator')->get('Home'); ?></a></li>
        <li class="breadcrumb-item active"><?php echo e(__(session('current_title' , $title))); ?></li>
    </ol>
<?php session()->forget('current_title') ?>
</section>
<!-- Main content -->
<section class="content">
    <?php echo $__env->yieldContent('page'); ?>
</section>
<?php /**PATH /var/www/html/meatz/Modules/Common/Views/admin/layout/page.blade.php ENDPATH**/ ?>