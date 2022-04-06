<div class="form-group">
    <label for="exampleInputFile"><?php echo e($mytitle); ?></label>
    <div class="input-group">
        <div class="mycustom-file">
            <input <?php echo e($required); ?> name="<?php echo e($name); ?>" type="file" class="mycustom-file-input">
            <label title="<?php echo app('translator')->get('Choose image'); ?>" class="mycustom-file-label">
                <div class="image">
                    <i class="fas fa-image"></i>
                    <span><?php echo app('translator')->get('Choose image'); ?></span>
                    <img onerror="this.style.display='none'" src="<?php echo e(url($value)); ?>">
                </div>
            </label>
        </div>
    </div>
</div>
<?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/components/image.blade.php ENDPATH**/ ?>