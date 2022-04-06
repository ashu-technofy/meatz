
<?php $__env->startSection('page'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__($title)); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="visible">#</th>
                            <th class="visible"><?php echo app('translator')->get('Client'); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Email'); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Phone'); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Status'); ?></th>
                            
                            <th class="visible"><?php echo app('translator')->get('Created at'); ?></th>
                            <th><?php echo app('translator')->get('Show'); ?></th>
                            <th><?php echo app('translator')->get('Delete'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e(!$row->seen ? 'unseen' : ''); ?>">
                            <td class="visible"><?php echo e($row->id); ?></td>
                            <td class="visible"><?php echo e($row->name); ?></td>
                            <td class="visible"><?php echo e($row->email); ?></td>
                            <td class="visible"><?php echo e($row->mobile); ?> </td>
                            <td class="visible"><?php echo e($row->status); ?> </td>
                            
                            <td class="visible"><?php echo e($row->created_at); ?></td>
                            <td class="actions_td">
                                <a class="btn btn-primary mlink" href="<?php echo e(route("admin.contactus.show" , $row->id)); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger mlink" href="<?php echo e(route("admin.contactus.show" , [$row->id , 'action' => 'delete'])); ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <ul class="paginator">
                <?php echo e($messages->links()); ?>

                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script>
    $('.table').DataTable({
        dom: 'Bfrtip',
        searching: false,
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        bSort : false,
        paging: false,//Dont want paging
        bPaginate: false,//Dont want paging
        buttons: [
            {
                extend: 'copyHtml5',
                text : "<i class='fas fa-copy'></i> <?php echo e(__('Copy')); ?>",
                exportOptions: {
                    columns: ['.visible']
                }
            },
            {
                extend: 'excelHtml5',
                text : "<i class='fas fa-file-excel'></i> <?php echo e(__('Export to excel')); ?>",
                exportOptions: {
                    columns: ['.visible']
                }
            },
            {
                extend: 'print',
                text : "<i class='fas fa-print'></i> <?php echo e(__('Print')); ?>",
                exportOptions: {
                    columns: ['.visible']
                }
            },
        ]
    });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Contactus/Views/admin/list.blade.php ENDPATH**/ ?>