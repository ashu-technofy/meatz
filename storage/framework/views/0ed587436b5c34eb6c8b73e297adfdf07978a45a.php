<div class="form-group">
    <label for="exampleInputEmail1"><?php echo e($mytitle); ?> <?php echo $name == 'wallet' ? "<b style='color:red;font-size:17px;font-weight:bold;padding:30px'>".__('Available Wallet is : ').$model->mywallet.' '.__('KD')."</b>" : ''; ?></label>
    <input <?php echo e($required); ?> type="number" step="0.1" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>" class="form-control"
        placeholder="<?php echo e($mytitle); ?>">
</div><?php /**PATH /var/www/html/meatz/Modules/Common/Views/components/number.blade.php ENDPATH**/ ?>