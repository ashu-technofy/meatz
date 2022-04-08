@extends('Common::admin.layout.page')
@section('page')
    <form action="{{ $action }}" method="post" data-title="{{ $title }}" enctype="multipart/form-data" class="action_form"
        novalidate>
        @foreach (request()->query() as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        @if ($method == 'put')
            {{ method_field('put') }}
        @endif
        @csrf
        @if (isset($groups))
            <div class="row">
                @foreach ($groups as $mytitle => $inputs)
                    <div class="col-md-6 col-sm-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{  $mytitle }}</h3>
                            </div>
                            <div class="card-body">
                                @foreach ($inputs as $myname => $input)
                                    <x-input :input="$input" :name="$myname" :model="$model" lang="all" />
                                @endforeach
                            </div>
                            @if ($loop->iteration == 1)
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"> <span>{{ __('Save') }}</span> <i
                                            class="fas fa-save"></i></button>
                                </div>
                            @endif
                        </div>
                        <!-- /.card -->
                    </div>
                @endforeach
            </div>
        @elseif(isset($lang_inputs) && count($lang_inputs))
            <div class="row">
                <div class="{{ isset($inputs) && $inputs ? 'col-md-8' : '' }} col-sm-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __($title) }} [<span
                                    class="action_type">{{ $method == 'post' ? __('Add') : __('Edit') }}</span>]</h3>
                        </div>
                        <div class="card-body">

                            <ul class="nav nav-tabs langs">
                                @foreach (config('app.locales') as $myname => $lang)
                                    <li class="{{ $loop->iteration == 1 ? 'active' : '' }}">
                                        <a data-toggle="tab" href="#{{ $myname }}"
                                            class="{{ $loop->iteration == 1 ? 'active' : '' }}">

                                            <span>{{ __($lang) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                @foreach (config('app.locales') as $lang_name => $lang)
                                    <div id="{{ $lang_name }}"
                                        class="tab-pane fade {{ $loop->iteration == 1 ? 'in active show' : '' }}">
                                        @foreach ($lang_inputs as $myname => $input)
                                            <x-input :input="$input" :name="$myname" :model="$model" :lang="$lang_name" />
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @if (isset($has_images))
                                @php isset($images_text) ? $model->images_text = $images_text : '' @endphp
                                <x-input input="input" name="images[]" :model="$model" lang="all" />
                            @endif
                            @if (isset($has_map))
                                <script type="text/javascript"
                                    src='https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_APP_KEY') }}&sensor=false&language={{ app()->getLocale() }}'>
                                </script>
                                <x-input input="input" name="map" :model="$model" lang="all" />
                            @endif

                            @if (isset($includes))
                                @foreach ($includes as $view)
                                    @include($view)
                                @endforeach
                            @endif
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"> <span>{{ __('Save') }}</span> <i
                                    class="fas fa-save"></i></button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                @if (isset($inputs) && $inputs)
                    <div class="col-md-4 col-sm-12">
                        <!-- general form elements -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Options') }}</h3>
                            </div>
                            <div class="card-body">
                                @foreach ($inputs as $myname => $input)
                                    <x-input :input="$input" :name="$myname" :model="$model" lang="all" />
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                @endif
            </div>
        @else
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ __($title) }} [ {{ $method == 'post' ? __('Add') : __('Edit') }} ]</h3>
                </div>
                <div class="card-body">
                    @foreach ($inputs as $myname => $input)
                        <x-input :input="$input" :name="$myname" :model="$model" lang="all"/>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"> <span>{{ __('Save') }}</span> <i
                            class="fas fa-save"></i></button>
                </div>
            </div>
            <!-- /.card -->
        @endif
        <input type="hidden" id="storeId" value="{{isset($id) ? $id : 0}}" />
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
              placeholder: "{{ __('Write here') }}",
              height: 300,
          });
        });

        $(document).on('change', '#category', function(){
          var catId = $(this).val();
            if(catId){
              $.ajax({
                    url:"/admin/sub-categories/"+catId,
                    type:'GET',
                    success: function(responceData){
                        $("#sub-cat").html(responceData);
                    }
                });
            }else{
                $("#sub-cat").html('');
            }
        });
    </script>
@stop
