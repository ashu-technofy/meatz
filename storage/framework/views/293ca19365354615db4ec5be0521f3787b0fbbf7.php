<script>
    $("[name='box_id'],[name='store_id'],[name='product_id']").closest('.form-group').hide();

    $("[name='model']").change(function(){
        $("[name='box_id'],[name='store_id'],[name='product_id']").closest('.form-group').hide();
        var val = $(this).val();
        if(val == 'box'){
            $("[name='box_id']").closest('.form-group').show();
        }else if(val == 'store'){
            $("[name='store_id']").closest('.form-group').show();
        }else if(val == 'product'){
            $("[name='product_id']").closest('.form-group').show();
        }
    });
</script>
<?php /**PATH /home/u878064185/domains/testingjunction.tech/public_html/meatz/Modules/Sliders/Views/admin/script.blade.php ENDPATH**/ ?>