
<?php $__env->startSection('page'); ?>
<div class="row">
   <div class="col-md-8 col-sm-12">
      <!-- general form elements -->
     <form method="post" action="subcategories/store" enctype="multipart/form-data">
      <div class="card card-primary">
         <div class="card-header">
            <h3 class="card-title">Sub Category [<span class="action_type">Add</span>]</h3>
         </div>
         <div class="card-body">
            <ul class="nav nav-tabs langs">
               <li class="active">
                  <a data-toggle="tab" href="#ar" class="active">
                  <span>Arabic</span>
                  </a>
               </li>
               <li class="">
                  <a data-toggle="tab" href="#en" class="">
                  <span>English</span>
                  </a>
               </li>

            </ul>
            <div class="tab-content">
               <div id="ar" class="tab-pane fade in active show">
                     <?php echo csrf_field(); ?>
                    <div class="form-group">
                         <div class="form-group">
                            <label>Select Category</label>
                            <select required="" name="category" class="select2 select2-hidden-accessible" data-placeholder="Type" style="width: 100%;" searchable="" tabindex="-1" aria-hidden="true">
                              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $cate = json_decode($category->name , true); ?>
                                 <option value="<?php echo e($category->id); ?>"><?php echo e($cate['en']); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                       <label for="exampleInputEmail1">Sub Category</label>
                       <input required="" type="text" name="name" value="" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                       <label for="exampleInputEmail1">Sub Category Image</label>
                       <input type="file" name="image" required="" class="form-control" placeholder="Select Subcategory Image">
                    </div>

               </div>
               <!-- <div id="en" class="tab-pane fade ">
                  <div class="form-group">
                     <label for="exampleInputEmail1">Name</label>
                     <input required="" type="text" name="name[en]" value="" class="form-control" placeholder="Name">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputEmail1">About</label>
                     <textarea required="" name="about[en]" rows="5" class="form-control" placeholder="About"></textarea>
                  </div>
                  <div class="form-group">
                     <label for="exampleInputEmail1">Address</label>
                     <input type="text" name="address[en]" value="" class="form-control" placeholder="Address">
                  </div>
               </div> -->
            </div>
         </div>
         <!-- /.card-body -->
         <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <span>Save</span> <i class="fas fa-save"></i></button>
         </div>
         </form>
      </div>
      <!-- /.card -->
   </div>
   <div class="col-md-4 col-sm-12"></div>
</div>
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            $('.textarea').summernote({
                placeholder: "<?php echo e(__('Write here')); ?>",
                height: 300,
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Stores/Views/admin/form.blade.php ENDPATH**/ ?>