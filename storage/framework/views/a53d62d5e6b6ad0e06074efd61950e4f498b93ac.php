<div class="form-group">
    <label for="exampleInputFile"><?php echo app('translator')->get('Images'); ?> <?php echo e($model->images_text ?? ''); ?></label>
    <div class="input-group">
        <div class="multi_images">
            <?php $__currentLoopData = $model->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="imgTag">
                <a id="<?php echo e($image->id); ?>" class="remove_img"><i class="fas fa-trash"></i></a>
                <img src="<?php echo e($image->image); ?>" alt="">
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="mycustom-file">
                <input multiple name="images[]" type="file" class="mycustom-file-input" multiple>
                <label title="اختر صور" class="mycustom-file-label">
                    <div class="image">
                        <i class="fas fa-image"></i>
                        <span>اختر صور</span>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
<script>
    $('.remove_img').click(function () {
        var btn = $(this);
        Swal.fire({
            text: "هل تريد الحذف",
            showConfirmButton: true,
            confirmButtonText: "نعم",
            showCancelButton: true,
            cancelButtonText: "لا"
        }).then(function (ok) {
            if (ok.value) {
                var model = "<?php echo e(str_replace('\\' , '/' , get_class($model))); ?>";
                $.get("<?php echo e(route('admin.remove_img')); ?>", {
                    id: btn.attr('id'),
                    model: model
                });
                btn.closest('.imgTag').remove();
            }
        });
    });

</script>
<?php /**PATH /var/www/html/meatz/Modules/Common/Views/components/images.blade.php ENDPATH**/ ?>