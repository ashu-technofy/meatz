
<?php $__env->startSection('page'); ?>
<form action="<?php echo e($action); ?>" method="post" enctype="multipart/form-data" class="action_form" novalidate>
    <?php echo csrf_field(); ?>
    <!-- general form elements -->
    <div class="card card-primary contactsDiv">
        <div class="card-header">
            <h3 class="card-title"><?php echo e($title); ?></h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    
                    <th><?php echo app('translator')->get('Type'); ?></th>
                    <th><?php echo app('translator')->get('Value'); ?></th>
                    <th><?php echo app('translator')->get('Delete'); ?></th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($contact->key && $contact->value): ?>
                    <tr>
                        
                        <td>
                            <select name="key[]" id="" class="form-control">
                                <?php $__currentLoopData = social_types(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($key == $contact->key ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($type); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td><input type="text" name="value[]"
                                value="<?php echo e($contact->value ?? $contact->value->all ?? ''); ?>" class="form-control"></td>
                        <td><a href="#!" class="remove_contact btn btn-danger" id="<?php echo e($contact->id); ?>"><i
                                    class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr class="contactTr">
                        
                        <td>
                            <select name="key[]" id="" class="form-control">
                                <?php $__currentLoopData = social_types(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($model->key == $key ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($type); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </td>
                        <td><input type="text" name="value[]" value="<?php echo e($model->value->all ?? ''); ?>"
                                class="form-control">
                        </td>
                        <td><a href="#!" class="remove_contact btn btn-danger" id="0"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center"><a href="#!" class="add_contact">+ <?php echo app('translator')->get('Add another
                                contact'); ?></a>
                        </td>
                    </tr>
                </tfoot>
            </table>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <span>حفظ</span> <i class="fas fa-save"></i></button>
        </div>
    </div>
    <!-- /.card -->
</form>
<script>
    $('.select2').select2();
    $('body').on('click', '.remove_contact', function () {
        var id = parseInt($(this).attr('id'));
        var btn = $(this);
        if (id && id != 0) {
            Swal.fire({
                icon: "warning",
                text: "هل تريد الحذف",
                showConfirmButton: true,
                confirmButtonText: "نعم",
                showCancelButton: true,
                cancelButtonText: "لا"
            }).then(function (ok) {
                if (!ok.value) {
                    return false;
                } else {
                    $.get("<?php echo e(route('admin.remove_contact')); ?>", {
                        id: id
                    });
                    btn.closest('tr').remove();
                }
            });
        } else {
            btn.closest('tr').remove();
        }
    });
    $('.add_contact').click(function () {
        $('tbody').append("<tr>" + $('.contactTr').html() + "</tr>");
        return false;
    })

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/settings/contacts.blade.php ENDPATH**/ ?>