
<script>
    if (typeof fromajax === 'undefined') {
        localStorage.setItem('route', window.location);
        window.location = "{{ route('admin.load') }}";
    } else {
        localStorage.setItem('route', 0);
    }
    $.get("{{ route('admin.add_actions') }}" , {
        'title' : "{{ $title }}" ,
        "url"  : "{{ request()->url() }}" ,
        "name" : "{{ $model->name->ar ?? $model->name ?? '' }}"
        });

</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @lang('Dashboard')
        <small>{{ app_setting('title') }}</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="mlink" href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i>
                @lang('Home')</a></li>
        <li class="breadcrumb-item active">{{  __(session('current_title' , $title)) }}</li>
    </ol>
@php session()->forget('current_title') @endphp
</section>
<!-- Main content -->
<section class="content">
    @yield('page')
</section>