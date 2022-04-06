<?php $__env->startSection('page'); ?>
    <form action="<?php echo e($action); ?>" method="post" data-title="<?php echo e($title); ?>" enctype="multipart/form-data" class="action_form"
        novalidate>
        <?php $__currentLoopData = request()->query(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($method == 'put'): ?>
            <?php echo e(method_field('put')); ?>

        <?php endif; ?>
        <?php echo csrf_field(); ?>
        <?php if(isset($groups)): ?>
            <div class="row">
                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mytitle => $inputs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-sm-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo e($mytitle); ?></h3>
                            </div>
                            <div class="card-body">
                                <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myname => $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3 = $component; } ?>
<?php $component = $__env->getContainer()->make(\Modules\Common\Components\Input::class, ['input' => $input,'name' => $myname,'model' => $model,'lang' => 'all']); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3)): ?>
<?php $component = $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3; ?>
<?php unset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if($loop->iteration == 1): ?>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"> <span><?php echo e(__('Save')); ?></span> <i
                                            class="fas fa-save"></i></button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php elseif(isset($lang_inputs) && count($lang_inputs)): ?>
            <div class="row">
                <div class="<?php echo e(isset($inputs) && $inputs ? 'col-md-8' : ''); ?> col-sm-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo e(__($title)); ?> [<span
                                    class="action_type"><?php echo e($method == 'post' ? __('Add') : __('Edit')); ?></span>]</h3>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-tabs langs">
                                <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myname => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="<?php echo e($loop->iteration == 1 ? 'active' : ''); ?>">
                                        <a data-toggle="tab" href="#<?php echo e($myname); ?>"
                                            class="<?php echo e($loop->iteration == 1 ? 'active' : ''); ?>">

                                            <span><?php echo e(__($lang)); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>

                            <div class="tab-content">
                                <?php $__currentLoopData = config('app.locales'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang_name => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div id="<?php echo e($lang_name); ?>"
                                        class="tab-pane fade <?php echo e($loop->iteration == 1 ? 'in active show' : ''); ?>">
                                        <?php $__currentLoopData = $lang_inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myname => $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if (isset($component)) { $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3 = $component; } ?>
<?php $component = $__env->getContainer()->make(\Modules\Common\Components\Input::class, ['input' => $input,'name' => $myname,'model' => $model,'lang' => $lang_name]); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3)): ?>
<?php $component = $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3; ?>
<?php unset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if(isset($has_images)): ?>
                                <?php isset($images_text) ? $model->images_text = $images_text : '' ?>
                                <?php if (isset($component)) { $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3 = $component; } ?>
<?php $component = $__env->getContainer()->make(\Modules\Common\Components\Input::class, ['input' => 'input','name' => 'images[]','model' => $model,'lang' => 'all']); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3)): ?>
<?php $component = $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3; ?>
<?php unset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                            <?php endif; ?>
                            <?php if(isset($has_map)): ?>
                                <script type="text/javascript"
                                    src='https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_APP_KEY')); ?>&sensor=false&language=<?php echo e(app()->getLocale()); ?>'>
                                </script>
                                <?php if (isset($component)) { $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3 = $component; } ?>
<?php $component = $__env->getContainer()->make(\Modules\Common\Components\Input::class, ['input' => 'input','name' => 'map','model' => $model,'lang' => 'all']); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3)): ?>
<?php $component = $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3; ?>
<?php unset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php if(isset($includes)): ?>
                                <?php $__currentLoopData = $includes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $view): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make($view, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"> <span><?php echo e(__('Save')); ?></span> <i
                                    class="fas fa-save"></i></button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <?php if(isset($inputs) && $inputs): ?>
                    <div class="col-md-4 col-sm-12">
                        <!-- general form elements -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo e(__('Options')); ?></h3>
                            </div>
                            <div class="card-body">
                                <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myname => $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3 = $component; } ?>
<?php $component = $__env->getContainer()->make(\Modules\Common\Components\Input::class, ['input' => $input,'name' => $myname,'model' => $model,'lang' => 'all']); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3)): ?>
<?php $component = $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3; ?>
<?php unset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo e(__($title)); ?> [ <?php echo e($method == 'post' ? __('Add') : __('Edit')); ?> ]</h3>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $inputs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myname => $input): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3 = $component; } ?>
<?php $component = $__env->getContainer()->make(\Modules\Common\Components\Input::class, ['input' => $input,'name' => $myname,'model' => $model,'lang' => 'all']); ?>
<?php $component->withName('input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php if (isset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3)): ?>
<?php $component = $__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3; ?>
<?php unset($__componentOriginal9105093428cd290398d19e0cffaa4bb44f1e9de3); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> <span><?php echo e(__('Save')); ?></span> <i
                            class="fas fa-save"></i></button>
                </div>
            </div>
            <!-- /.card -->
        <?php endif; ?>
        <input type="hidden" id="storeId" value="<?php echo e(isset($id) ? $id : 0); ?>" />
    </form>
  
    <script>
        $('.select2').select2();
        $(document).ready(function() {
          var storeId = $('#storeId').val();
          var catId = $('#category').val();

          if (storeId>0 && (catId.length)>0) {
            $.ajax({
                  url:"/admin/selected-sub-categories/"+storeId+"/"+catId,
                  type:'GET',
                  success: function(responceData){
                      $("#sub-cat").html(responceData);
                  }
              });
            }

          $('.textarea').summernote({
              placeholder: "<?php echo e(__('Write here')); ?>",
              height: 300,
          });
        });

        $(document).on('change', '#category', function(){
          var catId = $(this).val();
          $.ajax({
                url:"/admin/sub-categories/"+catId,
                type:'GET',
                success: function(responceData){
                    $("#sub-cat").html(responceData);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/form.blade.php ENDPATH**/ ?>