<div class="form-group">
    <label for="exampleInputFile">@lang('Images') {{ $model->images_text ?? '' }}</label>
    <div class="input-group">
        <div class="multi_images">
            @foreach($model->images as $image)
            <div class="imgTag">
                <a id="{{ $image->id }}" class="remove_img"><i class="fas fa-trash"></i></a>
                <img src="{{ $image->image }}" alt="">
            </div>
            @endforeach
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
                var model = "{{ str_replace('\\' , '/' , get_class($model)) }}";
                $.get("{{route('admin.remove_img')}}", {
                    id: btn.attr('id'),
                    model: model
                });
                btn.closest('.imgTag').remove();
            }
        });
    });

</script>
