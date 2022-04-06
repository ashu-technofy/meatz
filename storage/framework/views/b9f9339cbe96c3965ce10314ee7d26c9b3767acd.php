
<?php $__env->startSection('page'); ?>
<style>
    @media  print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }

    .order_bill th {
        width: 35%;
    }
</style>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?php echo app('translator')->get('Order Details'); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <tbody>
                        <tr>
                            <th><?php echo app('translator')->get("Order ID"); ?></th>
                            <td><?php echo e($order->code ?? "MZ".$order->id); ?></td>
                        </tr>
                        <?php if($order->status == 'Canceled'): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <td>
                                <?php echo app('translator')->get('Canceled'); ?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <td>
                                <select <?php echo e($order->status == 'cancel_request' ? 'readonly' : ''); ?> name="status" class="form-control" id="order_status" data-id="<?php echo e($order->id); ?>">
                                    <?php $statuses = order_statuses(); if(auth('stores')->check()) { unset($statuses[3]);} ?>
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e($order->current_status == $status ? 'selected' : ''); ?> value="<?php echo e($status); ?>">
                                        <?php echo app('translator')->get($status); ?>
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($order->status == 'cancel_request'): ?>
                                        <option selected disabled><?php echo app('translator')->get('Cancel Request'); ?></option>
                                    <?php endif; ?>
                                </select>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if($order->cancel_request == 1 && auth()->user()): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Cancellation Request'); ?></th>
                            <td>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php if($order->user): ?>
                                        <a class="btn btn-success accept_request" href="<?php echo e(route('admin.orders.cancel_request' , [$order->id , 'accept'])); ?>">
                                            <i class="fa fa-check"></i>
                                            <?php echo e(__('Refund to wallet')); ?>

                                        </a>
                                        <a class="btn btn-primary accept_request" href="<?php echo e(route('admin.orders.cancel_request' , [$order->id , 'accept' , 'refund' => 1])); ?>">
                                            <i class="fa fa-check"></i>
                                            <?php echo e(__('Refund to bank')); ?>

                                        </a>
                                        <?php else: ?>
                                        <a class="btn btn-primary accept_request" href="<?php echo e(route('admin.orders.cancel_request' , [$order->id , 'accept' , 'refund' => 1])); ?>">
                                            <i class="fa fa-check"></i>
                                            <?php echo e(__('Refund to bank')); ?>

                                        </a>
                                        <?php endif; ?>
                                        <a class="btn btn-danger accept_request" href="<?php echo e(route('admin.orders.cancel_request' , [$order->id , 'reject'])); ?>">
                                            <i class="fa fa-times"></i>
                                            <?php echo app('translator')->get('Reject'); ?>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?php echo app('translator')->get('Order Type'); ?></th>
                            <td><?php echo e($order->type != 'now' ? __("Deliver Later") : __("Deliver Now")); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Vendor'); ?></th>
                            <td><?php echo e($order->store->name->ar ?? 'Meatz'); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Payment method'); ?></th>
                            <td><?php echo e(__(ucfirst($order->payment_method))); ?></td>
                        </tr>
                        <?php if($order->payment_method != 'cash'): ?>
                            <tr>
                                <th><?php echo app('translator')->get('Paid'); ?></th>
                                <td><?php echo e($order->payment_method != 'cash' ? __('Yes') : __('No')); ?></td>
                            </tr>
                            <?php if($order->payment_id): ?>
                            <tr>
                                <th><?php echo app('translator')->get('Payment ID'); ?></th>
                                <td><?php echo e($order->payment_id); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($order->transaction_id): ?>
                            <tr>
                                <th><?php echo app('translator')->get('Transaction ID'); ?></th>
                                <td><?php echo e($order->transaction_id); ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($order->refund_refrence): ?>
                            <tr>
                                <th><?php echo app('translator')->get('Refund Ref'); ?></th>
                                <td><?php echo e($order->refund_refrence); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <tr>
                            <th><?php echo app('translator')->get('Total'); ?></th>
                            <td><?php echo e($order->total); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Sub total'); ?></th>
                            <td><?php echo e($order->subtotal); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery type'); ?></th>
                            <td><?php echo e($order->delivery_type == 'express' ? __('Express') : __('Normal')); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery'); ?></th>
                            <td><?php echo e($order->delivery); ?></td>
                        </tr>
                        <?php if($order->delivery_date): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery date'); ?></th>
                            <td><?php echo e($order->delivery_date); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($order->delivery_time && $order->delivery_type != 'express'): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery time'); ?></th>
                            <td><?php echo e($order->delivery_time); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($order->copon): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Copon'); ?></th>
                            <td><?php echo e($order->copon->code ?? ""); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?php echo app('translator')->get('Notes'); ?></th>
                            <td><?php echo e($order->notes); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><?php echo app('translator')->get('Client information'); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th><?php echo app('translator')->get('Client name'); ?></th>
                            <td><?php echo e($order->myuser->username); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Phone'); ?> </th>
                            <td><?php echo e($order->myuser->mobile); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Email'); ?></th>
                            <td><?php echo e($order->myuser->email); ?></td>
                        </tr>
                        <tr>
                            
                            <th><?php echo app('translator')->get('Address'); ?></th>
                            <td><?php echo $order->address->full_address ?? $order->guest->address ?? ''; ?></td>
                          
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Notes'); ?></th>
                            <td><?php echo e($order->address->address['notes'] ?? ''); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title"><?php echo app('translator')->get('Products'); ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Image'); ?></th>
                            <th><?php echo app('translator')->get('Product name'); ?></th>
                            <th><?php echo app('translator')->get('Store'); ?></th>
                            <th><?php echo app('translator')->get('Options'); ?></th>
                            <th><?php echo app('translator')->get('Price'); ?></th>
                            <th><?php echo app('translator')->get('Count'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->myproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><img src="<?php echo e($item['image']); ?>" height="100px"></td>
                            <td><?php echo e($item['title']); ?></td>
                            <td><?php echo e($item['store'] ? $item['store']->name->{app()->getLocale()} : ''); ?></td>
                            <td>
                                <?php $__currentLoopData = $item['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($row->name): ?>
                                    <li><?php echo e($row->name->ar); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><?php echo e($item['total']); ?></td>
                            <td><?php echo e($item['count']); ?></td>
                            <td><?php echo app('translator')->get($item['status']); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <!-- general form elements -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title">الفاتورة</h3>
                <a style="float: left; cursor: pointer;" class="btn btn-success print_bill"><i
                        class="fa fa-print"></i></a>
            </div>
            <div class="card-body order_bill">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th class="bill_title" colspan="2">الفاتورة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>رقم الطلب <br /> <?php echo e($order->code ?? "MZ".$order->id); ?></th>
                            <th>تاريخ الطلب <br /> <?php echo e(date('Y/m/d', strtotime($order->created_at))); ?></th>
                        </tr>
                        <tr>
                            <th>ساعة الطلب</th>
                            <td><?php echo e(date('h:i a', strtotime($order->created_at))); ?></td>
                        </tr>
                        <tr>
                            <th>تاريخ وصول الطلب</th>
                            <td><?php echo e($order->delivery_date); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Payment method'); ?></th>
                            <td><?php echo e(__(ucfirst($order->payment_method))); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery type'); ?></th>
                            <td><?php echo e($order->delivery_type == 'express' ? __('Express') : __('Normal')); ?></td>
                        </tr>
                        <?php if($order->delivery_date): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery date'); ?></th>
                            <td><?php echo e($order->delivery_date); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($order->delivery_time && $order->delivery_type != 'express'): ?>
                        <tr>
                            <th><?php echo app('translator')->get('Delivery time'); ?></th>
                            <td><?php echo e($order->delivery_time); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>عنوان العميل</th>
                            <td><?php echo $order->address->full_address ?? $order->guest->address ?? ''; ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-stripped bill_items">
                    <thead>
                        <tr>
                            <th>الصنف</th>
                            <th>المتجر</th>
                            <th>الإضافات</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $order->myproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th><?php echo e($item['title']); ?> <br /> الكمية المطلوبة : <?php echo e($item['count']); ?></th>
                            <td>
                                <?php echo e($item['store'] ? $item['store']->name->{app()->getLocale()} : ''); ?>

                                <br>
                                <?php echo e($item['store'] && $item['store']->address ? $item['store']->address->{app()->getLocale()} : ''); ?>

                            </td>
                            <th>
                                <?php $__currentLoopData = $item['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($row->name): ?>
                                    <li><?php echo e($row->name->ar); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </th>
                            
                            <th><?php echo e($item['total']); ?></th>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>طريقة الدفع</th>
                            <td colspan="3"><?php echo e(__(ucfirst($order->payment_method))); ?></td>
                        </tr>
                        <?php if($order->payment_method == '50'): ?>
                        <tr>
                            <th>المبلغ المتبقى</th>
                            <td colspan="2"><?php echo e($order->total / 2); ?> <?php echo app('translator')->get("KD"); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>سعر التوصيل</th>
                            <td colspan="3"><?php echo e($order->delivery); ?> <?php echo app('translator')->get("KD"); ?></td>
                        </tr>
                        <?php if($order->copon): ?>
                        <tr>
                            <th>الكوبون</th>
                            <td colspan="3"><?php echo e($order->copon->code ?? ""); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($order->discount): ?>
                        <tr>
                            <th>الخصم</th>
                            <td colspan="3"><?php echo e($order->discount ?? 0); ?> <?php echo app('translator')->get("KD"); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th>الإجمالى</th>
                            <th colspan="3"><?php echo e($order->total); ?> <?php echo app('translator')->get("KD"); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('.accept_request').click(function(){
        var t = confirm("هل أنت متأكد");
        if(!t){
            return false;
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Orders/Views/admin/show.blade.php ENDPATH**/ ?>