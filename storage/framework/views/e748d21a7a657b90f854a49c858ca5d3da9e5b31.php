<div class="form-group">
    <label for="exampleInputEmail1"><?php echo e($mytitle); ?></label>
    <input <?php echo e($required); ?> type="<?php echo e($input['type'] ?? 'text'); ?>" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" class="form-control"
        placeholder="<?php echo e($mytitle); ?>">
</div><?php /**PATH /var/www/html/meatz/Modules/Common/Views/components/input.blade.php ENDPATH**/ ?>