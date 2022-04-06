<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ app_setting('favicon') }}">

    <title>لوحة تحكم {{ app_setting('title') }}</title>
    @yield('head')
    <!-- bootstrap 4.0 -->
    <link rel="stylesheet"
        href="{{ url('/') }}/assets/admin/vendor_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="{{ url('/') }}/assets/admin/vendor_components/bootstrap/dist/css/bootstrap-extend.min.css">

    <!-- font awesome -->
    <link rel="stylesheet"
        href="{{ url('/') }}/assets/admin/vendor_components/font-awesome/css/font-awesome.min.css">
    <!-- theme style -->
    <link rel="stylesheet" href="{{ url('assets') }}/admin/css/master_style.css?ver=1.2">

    <link rel="icon" type="image/png" href="{{ app_setting('favicon') }}" />

    <!-- mpt_admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('assets') }}/admin/css/skins/_all-skins.css">
    <!-- google font -->
    <link href="//fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/admin/vendor_components/select2/dist/css/select2.min.css">
    <link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/assets/admin/vendor_components/datatables/datatables.min.css" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="{{ url('assets/admin/css') }}/custom.css?ver=1.112">
    @if (app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ url('assets/admin/css') }}/custom_en.css?ver=1.02">
    @endif
    <script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        @include('Common::admin.layout.header')

        @if (!auth('stores')->check())
            @include('Common::admin.layout.side')
        @endif


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="mycontent" @if (auth('stores')->check()) style="margin:0px;" @endif
            dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @lang('Dashboard')
                    <small>{{ app_setting('title') }}</small>
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="mlink" href="{{ url('/admin') }}"><i
                                class="fa fa-dashboard"></i>
                            @lang('Home')</a></li>
                    <li class="breadcrumb-item active">{{ __($title) }}</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                @yield('page')
            </section>
        </div>


        <!-- /.content-wrapper -->
        <footer class="main-footer" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            <div class="pull-left d-none d-sm-inline-block"></div>
        </footer>

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->

    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.4/umd/popper.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/assets/admin/vendor_components/jquery-ui/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="{{ url('/') }}/assets/admin/vendor_components/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ url('/') }}/assets/admin/vendor_components/datatables/datatables.min.js" type="text/javascript">
    </script>
    <script src="{{ url('/') }}/assets/admin/vendor_components/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- AdminLTE App -->
    <script src="{{ url('/') }}/assets/admin/js/template.js?ver=1.0"></script>
    <script src="{{ url('/') }}/assets/admin/js/demo.js?ver=1.0"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.min.js"></script>
    <script>
        // $(function() {
        //     $(".sidebar-menu").niceScroll();
        // });
        $('body').on('change', '.change_status', function() {
            $.get($(this).data('route'), {
                id: $(this).val()
            });
        });
        $('#mycontent').click(function() {
            $('.dropdown-menu').slideUp(0);
        });
        $('.dropdowntoggle').click(function() {
            $('.dropdown-menu').slideUp(0);
            $(this).closest('.dropdown').find('.dropdown-menu').slideToggle();
        });

        $('body').on('submit', '.action_form', function() {
            var form = $(this);

            if (form.hasClass('remove')) {
                Swal.fire({
                    text: "{{ __('Do you want to delete ?') }}",
                    icon: "warning",
                    showConfirmButton: true,
                    confirmButtonText: "{{ __('Yes') }}",
                    showCancelButton: true,
                    cancelButtonText: "{{ __('No') }}"
                }).then(function(ok) {
                    if (!ok.value) {
                        return false;
                    } else {
                        form_action(form);
                    }
                });
            } else {
                if (check_required(form)) {
                    form_action(form);
                }
            }
            return false;
        });
        $('body').on('click', '#search_form i', function() {
            $('#search_form').submit();
        });
        $('body').on('submit', '#search_form', function() {
            add_query($(this).find('input').val(), 'keyword');
            return false;
        });

        $('body').on('change', '.payment_method', function() {
            add_query($(this).val(), 'payment_method');
        });

        $('body').on('change', '.to_date', function() {
            add_query($(this).val(), 'to_date');
        });

        $('body').on('change', '.from_date', function() {
            add_query($(this).val(), 'from_date');
        });


        function add_query(val, key) {
            $('#mycontent').html(
                "<div class='pgloader'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
            var url = window.location.href;
            if (url.indexOf('?') >= 0) {
                url += "&" + key + "=" + encodeURIComponent(val);
            } else {
                url += "?" + key + "=" + encodeURIComponent(val);
            }
            window.history.pushState("", "", url);
            $('#mycontent').load(url);
            return false;
        }

        function form_action(form) {
            $('.card-footer button').prop('disabled', true);
            $('.sperror').remove();
            $('.fa-save').addClass('fa-spinner').addClass('fa-spin');
            var action = form.attr('action');
            $.ajax({
                url: action,
                type: 'POST',
                data: new FormData(form[0]),
                contentType: false,
                processData: false,
                success: function(result) {
                    $('.fa-save').remove();
                    $.get("{{ route('admin.add_actions') }}", {
                        "title": form.data('title'),
                        "url": action,
                        "name": form.find("input[type='text']").first().val(),
                        "method": form.find("[name='_method']").length > 0 ? 'update' : 'store'
                    });

                    Swal.fire({
                        position: 'top',
                        // icon: "success",
                        text: result.message,
                        showConfirmButton: false,
                    }).then(function() {
                        $('#mycontent').html(
                            "<div class='pgloader'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>"
                        );
                        localStorage.setItem('from_route', 1);
                        $('#mycontent').load(result.url);
                        window.history.pushState("", "", result.url);
                    });
                },
                error: function(errors) {
                    if (errors && errors.responseJSON.errors) {
                        var errors = errors.responseJSON.errors;
                        var keys = Object.keys(errors);
                        $.each(keys, function(i, el) {
                            form.find("[name='" + el + "']").closest('.form-group').find('label')
                                .append("<span class='sperror'>( " + errors[el][0] + " )</span>");
                        });
                        $('.fa-save').removeClass('fa-spin').removeClass('fa-spinner').closest('button')
                            .prop('disabled', false);
                        $('html, body').animate({
                            scrollTop: $('.sperror:visible:first').offset().top
                        }, 500);
                    }
                }
            });
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function check_required(form) {
            $('.requiredInp').removeClass('requiredInp');
            var inputs = form.find("[required]");
            var val = 0;
            inputs.each(function(key) {
                var tab = 0;
                if ($(this).val() == '') {
                    val = tab = 1;
                    $(this).addClass('requiredInp');
                    $(this).parent().find('.select2').addClass('requiredInp');
                } else if ($(this).attr('type') == 'checkbox' && inputs[key].checked == false) {
                    val = tab = 1;
                    $(this).parent().find('.checkmark').addClass('requiredInp');
                }
                if (tab == 1) {
                    var tab = $(this).closest('.tab-pane').attr('id');
                    if (tab) {
                        $("a[href='#" + tab + "']").addClass('requiredInp');
                    }
                }
            });
            if (val == 1) {
                if (!$('.contactsDiv').length) {
                    window.scrollTo({
                        top: $('.requiredInp:visible:first').offset().top - 10,
                        behavior: 'smooth',
                    });
                    return false;
                }
            }
            return true;
        }

        $('body').on('change', '.mycustom-file-input', function() {
            var image = $(this).parent().find('.image');
            var multiple = $(this).attr('multiple');
            readFile(this, image, multiple);
        });

        function readFile(input, image, multiple) {
            if (multiple) {
                $('.imgTag').remove();
                if (files = input.files) {
                    for (var i = files.length - 1; i >= 0; i--) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('.multi_images').prepend("<div class='imgTag'><img src='" + e.target.result +
                                "' /></div>");
                        }
                        reader.readAsDataURL(files[i]); // convert to base64 string
                    }
                }
            } else {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        image.find('img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                    image.find('img').show();
                    image.find('i,span').hide();
                } else {
                    image.find('img').hide();
                    image.find('i,span').show();
                }
            }
        }



        $('body').on('click', '.print_bill', function() {
            $('.order_bill').print();
        });

        $('body').on('change', '#order_status', function() {
            var order_id = $(this).data('id');
            $.get("{{ route('admin.orders.status') }}", {
                status: $(this).val(),
                order_id: order_id
            }, function(result) {
                Swal.fire({
                    text: result.message
                });
            });
        });

        var url = localStorage.getItem('route');
        if (url && url != 0 && fromajax != 1) {
            fromajax = 1;
            $('#mycontent').load(url);
            window.history.pushState("", "", url);
        }

        var fromajax = 0;
        $('body').on('click', '.mlink,.page-link', function() {
            $('.dropdown-menu').slideUp(0);
            fromajax = 1;
            localStorage.setItem('from_route', 1);
            var url = $(this).attr('href');
            $('#mycontent').html(
                "<div class='pgloader'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
            $('#mycontent').load(url);
            window.history.pushState("", "", url);
            return false;
        });


        window.addEventListener('popstate', function(e) {
            var url = window.location.href;
            fromajax = 1;
            localStorage.setItem('from_route', 1);
            $('#mycontent').html(
                "<div class='pgloader'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i></div>");
            $('#mycontent').load(url);
        });

        $('.sidebar-form input').keyup(function() {
            if (this.value.length > 0) {
                $("li.treeview").hide().filter(function() {
                    console.log('111');
                    return $(this).text().toLowerCase().indexOf($(".sidebar-form input").val()
                        .toLowerCase()) != -1;
                }).show();
            } else {
                $("li.treeview").show();
            }
        });


        $(document).ready(function() {
            setInterval(() => {
                $.get("{{ route('admin.notfs_counter') }}", function(result) {
                    if (result.orders > 0) {
                        $('.orders_count').html(result.orders);
                        $('.orders_count').addClass('bg-red');
                    } else {
                        $('.orders_count').html("");
                        $('.orders_count').removeClass('bg-red');
                    }

                    if (result.messages > 0) {
                        $('.messages_count').html(result.messages);
                        $('.messages_count').addClass('bg-red');
                    } else {
                        $('.messages_count').html("");
                        $('.messages_count').removeClass('bg-red');
                    }

                    if (result.requests > 0) {
                        $('.requests_count').html(result.requests);
                        $('.requests_count').addClass('bg-red');
                    } else {
                        $('.requests_count').html("");
                        $('.requests_count').removeClass('bg-red');
                    }
                });
            }, 30000);
        });
        // console.log('111111111');
        $('body').on('click', '.btn-box-tool .fa-minus', function() {
            var box = $(this).closest('.box');
            if (box.hasClass('collapsed')) {
                box.removeClass('collapsed');
                $(this).removeClass('fa-plus');
            } else {
                box.addClass('collapsed');
                $(this).addClass('fa-plus');
            }
        });

        $('body').on('click', '.btn-box-tool .fa-times', function() {
            var box = $(this).closest('.box');
            if (box.hasClass('hidden')) {
                box.removeClass('hidden');
            } else {
                box.addClass('hidden');
            }
        });

        
        $('body').on('click', '#add_more', function() {
            var cont = $('.empty_div').html();
            $('.myoptions').append(cont);
            // $('.select2').select2();
            return false;
        });
    </script>

</body>

</html>
