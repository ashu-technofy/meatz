
<?php $__env->startSection('page'); ?>
<div class="row list_page">
    <div class="col-12">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title"><?php echo e(__($title)); ?></h3>
                <?php if($can_add): ?>
                <a href="<?php echo e(route("admin.$name.create" , request()->query())); ?>" class="mlink btn btn-success"><i
                        class="fa fa-plus"></i>
                    <span><?php echo e(__("Add new")); ?></span></a>
                <?php endif; ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="example2" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="visible">#</th>
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$col_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="visible"><?php echo e(app()->getLocale() == 'ar' ? $col_title : str_replace("_" , " " , ucfirst($key))); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($links)): ?>
                            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e(__($link['title'])); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if(isset($switches)): ?>
                            <?php $__currentLoopData = $switches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if((!isset($option['on'])) || (isset($option['on']) && request($option['on'][0]) ==
                            $option['on'][1])): ?>
                            <th><?php echo e(__(str_replace('_' , ' ' , $title))); ?></th>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <th><?php echo e(__("Edit")); ?></th>
                            <?php if($can_delete): ?>
                            <th><?php echo e(__("Delete")); ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="visible"><?php echo e($loop->iteration); ?></td>
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $col_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $value = $key != 'created_at' && is_object($row->$key) ? $row->$key->{app()->getLocale()} :
                            $row->$key;
                            $relation = explode('_' , $key);
                            ?>
                            <?php if(in_array($key , ['image' , 'path'])): ?>
                            <td class="visible"><img src="<?php echo e($value); ?>" /></td>
                            <?php elseif(strpos($key , '_') !== false && $row->{$relation[0]}): ?>
                            <?php if(is_object($row->{$relation[0]}) && $relation[1] == 'count'): ?>
                            <td class="visible"><?php echo e($row->{$relation[0]}->count()); ?></td>
                            <?php else: ?>
                            <td class="visible"><?php echo e(is_object($row->{$relation[0]}->{$relation[1]}) ? $row->{$relation[0]}->{$relation[1]}->{app()->getLocale()} : $row->{$relation[0]}->{$relation[1]}); ?>

                            </td>
                            <?php endif; ?>
                            <?php else: ?>
                            <td class="visible"><?php echo e($value); ?></td>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if(isset($links)): ?>
                            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td>
                                <a class="btn btn-<?php echo e($link['type']); ?> mlink"
                                    href="<?php echo e(route($link['url'] , array_merge([$link['key'] => $row->id] , request()->query()))); ?>">
                                    <i class="fa <?php echo e($link['icon']); ?>"></i>
                                </a>
                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php if(isset($switches)): ?>
                            <?php $__currentLoopData = $switches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if((!isset($option['on'])) || (isset($option['on']) && request($option['on'][0]) ==
                            $option['on'][1])): ?>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" <?php echo e($row->$title ? 'checked' : ''); ?> class="change_status"
                                        value="<?php echo e($row->id); ?>" data-route="<?php echo e($option['url']); ?>">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <td>

                                <a class="btn btn-primary mlink" href="<?php echo e(route("admin.$name.edit" , array_merge([$row->id] , request()->query()))); ?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <?php if($can_delete): ?>
                            <td>
                                <form action="<?php echo e(route("admin.$name.destroy" , $row->id)); ?>" method="post"
                                    class="action_form remove">
                                    <?php echo csrf_field(); ?>
                                    <?php echo e(method_field('delete')); ?>

                                    <?php $__currentLoopData = request()->query(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($val); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <button type="submit" class="btn btn-danger removethis">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if($paginate): ?>
                <ul class="paginator">
                <?php echo e($rows->appends(request()->query())->links()); ?>

                </ul>
                <?php endif; ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script>
    $('.paginator a').addClass('mlink');
    $('.table').DataTable({
        dom: 'Bfrtip',
        searching: false,
        bInfo: false, //Dont display info e.g. "Showing 1 to 4 of 4 entries"
        paging: false,//Dont want paging
        bPaginate: false,//Dont want paging
        buttons: [
            {
                extend: 'copyHtml5',
                text : "<i class='fas fa-copy'></i> <?php echo e(__('Copy')); ?>",
                exportOptions: {
                    columns: ['.visible'],
                    modifier: {
                    page: 'all',
                    search: 'none'
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

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('Common::admin.layout.page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Common/Views/admin/list.blade.php ENDPATH**/ ?>