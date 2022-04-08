<div class="form-group">
    <label><?php echo e($mytitle); ?></label>
    <select <?php echo e($required); ?> name="<?php echo e($name); ?>" class="select2" id="<?php echo e(isset($input['id']) ? $input['id'] : ''); ?>" <?php echo e($input['multiple'] ?? ''); ?>

        data-placeholder="<?php echo e($mytitle); ?>" style="width: 100%;" searchable>
        <?php $__currentLoopData = $input['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(is_array($value)): ?>   
        <option <?php echo e(in_array($key , $value) ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
        <?php elseif(!is_object($value)): ?>
        <option <?php echo e($value == $key ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
        <?php elseif(is_object($value) && $value = $value->pluck('id')->toArray()): ?>
        <option <?php echo e(in_array($key , $value) ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e(__($val)); ?></option>
        <?php else: ?>
        <option value="<?php echo e($key); ?>"><?php echo e(__($val)); ?></option>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div><?php /**PATH /var/www/html/meatz/Modules/Common/Views/components/select.blade.php ENDPATH**/ ?>