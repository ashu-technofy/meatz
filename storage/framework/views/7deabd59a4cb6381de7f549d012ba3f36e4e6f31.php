<hr>
<div class="myoptions">
    <h2><?php echo app('translator')->get('Options'); ?></h2>
    <?php $__empty_1 = true; $__currentLoopData = $model->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-sm-12" style="margin-bottom: 10px">
            <div class="row">
                <div class="col-sm-11">
                    <select name="option_id[]" class="form-control">
                        <option value="0" disabled selected><?php echo app('translator')->get('Choose option'); ?></option>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e($row->id == $option->id ? 'selected' : ''); ?> value="<?php echo e($option->id); ?>">
                                <?php echo e($option->name->{app()->getLocale()}); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <a href="#!" class="remove_option btn btn-danger" data-id="<?php echo e($row->id); ?>">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-11">
                    <select name="option_id[]" class="form-control">
                        <option value="0" disabled selected><?php echo app('translator')->get('Choose option'); ?></option>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($option->id); ?>"><?php echo e($option->name->{app()->getLocale()}); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <a href="#!" class="remove_option btn btn-danger" data-id="0">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<hr>
<a href="#!" class="btn btn-success add_more">
    <i class="fa fa-plus"></i>
    <?php echo app('translator')->get('Add other option'); ?>
</a>

<div class="empty_div" style="position: absolute;width:0px;height:0px;opacity:0;">
    <div class="col-sm-12" style="margin-top:10px;">
        <div class="row">
            <div class="col-sm-11">
                <select name="option_id[]" class="form-control">
                    <option value="0" disabled selected><?php echo app('translator')->get('Choose option'); ?></option>
                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($option->id); ?>"><?php echo e($option->name->{app()->getLocale()}); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-sm-1">
                <a href="#!" class="remove_option btn btn-danger" data-id="0">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '.remove_option', function() {
        $.get("<?php echo e(route('admin.remove_product_option')); ?>", {
            id: $(this).data('id')
        });
        $(this).closest('.col-sm-12').remove();
        return false;
    });
    $('body').on('click', '.add_more', function() {
        var cont = $('.empty_div').html();
        $('.myoptions').append(cont);
        return false;
    });

</script>
<?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Stores/Views/admin/products/options.blade.php ENDPATH**/ ?>