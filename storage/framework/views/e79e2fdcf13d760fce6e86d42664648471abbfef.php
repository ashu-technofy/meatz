<?php $__env->startSection('page'); ?>
    <form action="<?php echo e(route('admin.store_periods', $store->id)); ?>" method="post" data-title="<?php echo e($title); ?>"
        enctype="multipart/form-data" class="action_form" novalidate>
        <?php echo csrf_field(); ?>
        <div class="card-body">
            <div class="myoptions">
                <h2><?php echo app('translator')->get('Periods'); ?></h2>
                <?php $__empty_1 = true; $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
                    <div class="col-sm-12" style="margin-bottom: 10px">
                        <div class="row">
                            <div class="col-sm-5">
                                <select class="form-control" name="from[]" id="">
                                    <?php $__currentLoopData = hours(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e($row->from == $h ? 'selected' : ''); ?> value="<?php echo e($h); ?>"><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-control" name="to[]" id="">
                                    <?php $__currentLoopData = hours(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e($row->to == $h ? 'selected' : ''); ?> value="<?php echo e($h); ?>"><?php echo e($val); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <a href="#!" class="remove_option btn btn-danger" data-dayid="<?php echo e($row->id); ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="form-control" name="from[]" id="">
                                <?php $__currentLoopData = hours(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($h); ?>"><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="to[]" id="">
                                <?php $__currentLoopData = hours(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($h); ?>"><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <a href="#!" class="remove_option btn btn-danger" data-dayid="0">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <hr>
            <a href="#!" class="btn btn-success" id="add_more">
                <i class="fa fa-plus"></i>
                <?php echo app('translator')->get('Add other option'); ?>
            </a>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary"> <span><?php echo e(__('Save')); ?></span> <i
                        class="fas fa-save"></i></button>
            </div>

            <div class="empty_div" style="position: absolute;width:0px;height:0px;opacity:0;">
                <div class="col-sm-12" style="margin-bottom: 10px">
                    <div class="row">
                        <div class="col-sm-5">
                            <select class="form-control" name="from[]" id="">
                                <?php $__currentLoopData = hours(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($h); ?>"><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="to[]" id="">
                                <?php $__currentLoopData = hours(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($h); ?>"><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <a href="#!" class="remove_option btn btn-danger" data-dayid="0">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $('body').on('click', '.remove_option', function() {
            $.get("<?php echo e(route('admin.remove_store_period')); ?>", {
                day_id: $(this).data('dayid'),
                store_id: "<?php echo e($store->id); ?>"
            });
            $(this).closest('.col-sm-12').remove();
            return false;
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Stores/Views/admin/periods.blade.php ENDPATH**/ ?>