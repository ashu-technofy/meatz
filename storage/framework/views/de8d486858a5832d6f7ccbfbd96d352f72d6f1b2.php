
<?php $__env->startSection('page'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo e(__($title)); ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="search-box" style="
                width: 100%;
                max-width: 300px;
                margin: auto;">
                    <div class="form-group">
                        <select name="delivery_type" class="form-control" id="">
                            <option value="delivery_type" selected disabled><?php echo app('translator')->get('Delivery type'); ?></</option>
                            <option value="usual"><?php echo app('translator')->get('Normal'); ?></option>
                            <option <?php echo e(request('delivery_type') == 'express' ? 'selected' : ''); ?> value="express"><?php echo app('translator')->get('Express'); ?></option>
                        </select>
                        <br>
                        <select name="payment_method" class="form-control payment_method" id="">
                            <option selected disabled><?php echo app('translator')->get('Payment method'); ?></option>
                            <option value="knet"><?php echo app('translator')->get('KNET'); ?></option>
                            
                            <option <?php echo e(request('payment_method') == 'wallet' ? 'selected' : ''); ?> value="wallet"><?php echo app('translator')->get('Wallet'); ?></option>
                        </select>
                    </div>
                </div>
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="statis">
                        <tr>
                            <th class="visible"><span><?php echo app('translator')->get("Total orders"); ?></span> <?php echo e($count); ?></th>
                            <th class="visible"><span><?php echo app('translator')->get("Total sales"); ?></span> <?php echo e($total); ?> <?php echo app('translator')->get('KD'); ?></th>
                            
                            
                            <th class="visible"><span><?php echo app('translator')->get('Total wallet'); ?></span> <?php echo e($total_wallet); ?> <?php echo app('translator')->get('KD'); ?></th>
                            <th class="visible"><span><?php echo app('translator')->get('Total 50'); ?></span> <?php echo e($total_50); ?> <?php echo app('translator')->get('KD'); ?></th>
                            <th class="visible"><span><?php echo app('translator')->get('Total knet'); ?></span> <?php echo e($total_knet); ?> <?php echo app('translator')->get('KD'); ?></th>
                            <th class="visible"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th class="visible"><?php echo app('translator')->get("Order ID"); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Client'); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Total'); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Delivery type'); ?></th>
                            <th class="visible"><?php echo app('translator')->get('Payment method'); ?></th>
                            <?php if(request('status') == 'cancel_request'): ?>
                            <th class="visible"><?php echo app('translator')->get('Cancel status'); ?></th>
                            <?php endif; ?>
                            <th class="visible"><?php echo app('translator')->get('Created at'); ?></th>
                            <th><?php echo app('translator')->get('Show'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="visible"><?php echo e($row->code ?? "ZW".$row->id); ?></td>
                            <td class="visible"><?php echo e($row->myuser->username ?? '#'); ?></td>
                            <td class="visible"><?php echo e($row->total); ?> <?php echo app('translator')->get("KD"); ?></td>
                            <td class="visible"><?php echo e($row->delivery_type == 'express' ? __('Express') : __('Normal')); ?></td>
                            <td class="visible"><?php echo app('translator')->get(ucfirst($row->payment_method)); ?></td>
                            <?php if(request('status') == 'cancel_request'): ?>
                            <td class="visible">
                                <?php if($row->cancel_request == -1): ?>
                                    <?php echo app('translator')->get('Rejected'); ?>
                                <?php elseif($row->cancel_request == 2): ?>
                                    <?php echo app('translator')->get('Accepted'); ?>
                                <?php else: ?>
                                    <?php echo app('translator')->get('Pending request'); ?>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                            <th class="visible"><?php echo e($row->created_at); ?></th>
                            <td class="actions_td">
                                <a class="btn btn-primary mlink" href="<?php echo e(route("admin.orders.show" , $row->id)); ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <ul class="paginator">
                <?php echo e($orders->appends(request()->query())->links()); ?>

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
        paging: false,//Dont want paging
        bPaginate: false,//Dont want paging
        ordering:false,
        buttons: [
            {
                extend: 'copyHtml5',
                text : "<i class='fas fa-copy'></i> <?php echo e(__('Copy')); ?>",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    selected: 'none'   
                    }
                },
            },
            {
                extend: 'excelHtml5',
                text : "<i class='fas fa-file-excel'></i> <?php echo e(__('Export to excel')); ?>",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    search: 'none'   
                    }
                },
            },
            {
                extend: 'print',
                text : "<i class='fas fa-print'></i> <?php echo e(__('Print')); ?>",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    search: 'none'   
                    }
                },
            },
        ]
    });

    $("[name='delivery_type']").change(function(){
        add_query($(this).val(), 'delivery_type');
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Orders/Views/admin/index.blade.php ENDPATH**/ ?>